<?php
# Linux Day 2016 - Construct a database event
# Copyright (C) 2016 Valerio Bozzolan, Ludovico Pavesi
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

trait EventTrait {
	function getEventID() {
		isset( $this->event_ID )
			|| error_die("Missing event_ID");

		return $this->event_ID;
	}

	function getEventUID() {
		isset( $this->event_uid )
			|| error_die("Missing event_uid");

		return $this->event_uid;
	}

	function getEventURL() {
		return URL . sprintf(
			PERMALINK_EVENT,
			$this->getConferenceUID(),
			$this->getEventUID(),
			$this->getChapterUID()
		);
	}

	function forceEventPermalink() {
		$url = $this->getEventURL();
		if( $url !== request_uri() ) {
			http_redirect( $url );
		}
	}

	function getEventTitle() {
		isset( $this->event_title )
			|| error_die("Missing event_title");

		return _( $this->event_title );
	}

	/**
	 * Event is joined with an user?
	 */
	function eventHasUser() {
		return isset( $this->user_uid );
	}

	function getEventStart($f) {
		return $this->event_start->format($f);
	}

	function getEventEnd($f) {
		return $this->event_end->format($f);
	}

	function hasEventImage() {
		return isset( $this->event_img );
	}

	function getEventImage() {
		return site_page($this->event_img, URL);
	}

	function hasEventDescription() {
		property_exists($this, 'event_description')
			|| error_die("Missing event_description");

		return isset( $this->event_description );
	}

	function getEventDescription() {
		return _( $this->event_description );
	}

	function printEventDescription() {
		echo nl2br( $this->getEventDescription() );
	}

	function queryEventUsers($fields = null) {
		return User::getQueryUsersByEvent( $this->getEventID() )
			->selectField([
				'user_uid',
				'user_name',
				'user_surname',
				'user_email',
				'user_image'
			])
			->selectField($fields)
			->query();
	}

	function hasPermissionToEditEvent() {
		return has_permission('edit-events');
	}
}

class_exists('User');
class_exists('Conference');
class_exists('Chapter');
class_exists('Room');
class_exists('Track');

class Event {
	use EventTrait, UserTrait, ConferenceTrait, ChapterTrait, RoomTrait, TrackTrait;

	function __construct() {
		self::normalize($this);
		User::normalize($this);
		Conference::normalize($this);
		Chapter::normalize($this);
		Room::normalize($this);
		Track::normalize($this);
	}

	static function normalize(& $t) {
		if( isset( $t->event_ID ) ) {
			$t->event_ID = (int) $t->event_ID;
		}
		if( isset( $t->event_start ) ) {
			datetime2php($t->event_start);
		}
		if( isset( $t->event_end ) ) {
			datetime2php($t->event_end);
		}
	}

	/**
	 * @return DynamicQuery
	 */
	function getStandardQueryEvent() {
		$q = new DynamicQuery();
		$q->selectField( [
			'event.event_ID',
			'event_uid',
			'event_title',
			'event_subtitle',
			'event_abstract',
			'event_description',
			'event_language',
			'event_start',
			'event_end',
			'event_img',
			'room_uid',
			'room_name',
			'track_uid',
			'track_name',
			'chapter_uid',
			'chapter_name',
			'conference.conference_ID',
			'conference_uid',
			'conference_title'
		] );
		$q->useTable( [ 'event', 'conference', 'room', 'track', 'chapter' ] );
		$q->appendCondition('event.conference_ID = conference.conference_ID');
		$q->appendCondition('event.room_ID = room.room_ID');
		$q->appendCondition('event.chapter_ID = chapter.chapter_ID');
		$q->appendCondition('event.track_ID = track.track_ID');
		return $q;
	}

	/**
	 * @return DynamicQuery
	 */
	static function getQueryEvent($event_uid) {
		$q = Event::getStandardQueryEvent();
		return $q->appendCondition( sprintf(
			"event_uid = '%s'",
			esc_sql( luser_input( $event_uid, 64 ) )
		) );
	}

	/**
	 * @return DynamicQuery
	 */
	static function getQueryEventByConference( $event_uid, $conference_uid ) {
		$q = Event::getQueryEvent($event_uid);
		return $q->appendCondition( sprintf(
			"conference_uid = '%s'",
			esc_sql( luser_input( $conference_uid, 64 ) )
		) );
	}

	/**
	 * @return DynamicQuery
	 */
	static function getQueryEventByConferenceChapter( $event_uid, $conference_uid, $chapter_uid ) {
		$q = Event::getQueryEventByConference($event_uid, $conference_uid);
		return $q->appendCondition( sprintf(
			"chapter_uid = '%s'",
			esc_sql( luser_input( $chapter_uid, 64 ) )
		) );
	}

	/**
	 * @return Event
	 */
	static function getEventByConference( $event_uid, $conference_uid ) {
		return Event::getQueryEventByConference($event_uid, $conference_uid)
		            ->getRow('Event');
	}

	/**
	 * @return Event
	 */
	static function getEventByConferenceChapter( $event_uid, $conference_uid, $chapter_uid ) {
		return Event::getQueryEventByConferenceChapter($event_uid, $conference_uid, $chapter_uid)
		            ->getRow('Event');
	}

	/**
	 * Query events ordered by tracks with event-users.
	 * Every row is filled with an handy array of users (`->users`) and an incremental hour (`->hour`)
	 *
	 * @return array
	 */
	static function getDailyEvents( $conference_ID = null, $chapter_uid ) {
		global $JOIN;

		// Yes, I want to obtain duplicates
		$events = query_results(
			sprintf(
				'SELECT '.
					'track_uid, '.
					'track_name, '.
					'chapter_uid, '.
					'event.event_ID, '.
					'event_uid, '.
					'event_title, '.
					'event_start, '.
					'event_end, '.
					'user_uid, '.
					'user_name, '.
					'user_surname, '.
					'conference_uid '.
					" FROM {$JOIN('conference', 'track', 'chapter', 'event')} ".
						"LEFT JOIN {$JOIN('event_user')} ".
							'ON (event.event_ID = event_user.event_ID) '.
						"LEFT JOIN {$JOIN('user')} ".
							'ON (event_user.user_ID = user.user_ID) '.
				'WHERE '.
					'event.conference_ID = %d AND '.
					'event.conference_ID = conference.conference_ID AND '.
					'event.track_ID = track.track_ID AND '.
					'event.chapter_ID = chapter.chapter_ID AND '.
					"chapter_uid = '%s'" .
				'ORDER BY '.
					'event_start, '.
					'track_order'
				,
				$conference_ID,
				esc_sql( $chapter_uid )
			),
			'Event'
		);

		// Users indexed by event_ID
		$users = [];
		foreach($events as $event) {
			if( ! isset( $users[ $event->event_ID ] ) ) {
				$users[ $event->event_ID ] = [];
			}

			if( $event->eventHasUser() ) {
				////////////////////////////////////////////////////////////////////////////////////
				// READ AND DO NOT EXECUTE IF USING PHP < 5 TO DO NOT WASTE YOUR SERVER RESOURCES //
				// (Or do it everywhere if you are writing Joomla! and WordPress plugins. asd.)   //
				////////////////////////////////////////////////////////////////////////////////////

				// You will say: «Hey, `$event` is not a "clean" user! Here you are creating a multi-dimensional recursive big shit!»
				// But... as in PHP5+ every object is assigned by reference: NOT by value!
				// So... this is only a reference tree: it's all OK (IN READ-ONLY...).
			 	$users[ $event->event_ID ][] = $event;
			}
		}

		$incremental_hour = 0;
		$last_hour = -1;
		$last_event_ID = -1;
		foreach($events as $i => $event) {
			// Remember that it's a JOIN with duplicates
			if( $last_event_ID === $event->event_ID ) {
				unset( $events[ $i ] );
				continue;
			}

			// 'G': date() 0-24 hour format without leading zeros
			$hour = (int) $event->getEventStart('G');

			// Next hour
			if( $hour !== $last_hour ) {
				if( $incremental_hour === 0 ) {
					$incremental_hour = 1;
				} else {
					// `$hour - $last_hour` is often only 1
					// Set to ++ to skip empty spaces
					$incremental_hour += $hour - $last_hour;
				}
			}

			// Fill `->hour`
			$event->hour = $incremental_hour;

			// Fill `->users`
			$event->users = $users[ $event->event_ID ];

			$last_event_ID = $event->event_ID;

			$last_hour = $hour;
		}

		return $events;
	}
}
