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
		return _( $this->event_title );
	}

	function getEventSubtitle() {
		return _( $this->event_subtitle );
	}

	/**
	 * Event is joined with an user?
	 */
	function eventHasUser() {
		return isset( $this->user_uid );
	}

	function getEventHumanStart() {
		return HumanTime::diff( $this->event_start );
	}

	function getEventHumanEnd() {
		return HumanTime::diff( $this->event_end );
	}

	function getEventStart($f = 'Y-m-d H:i:s') {
		return $this->event_start->format($f);
	}

	function getEventEnd($f = 'Y-m-d H:i:s') {
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

	function hasEventAbstract() {
		property_exists($this, 'event_abstract')
			|| error_die("Missing event_abstract");

		return isset( $this->event_abstract );
	}

	function getEventDescription() {
		return $this->event_description;
	}

	function getEventAbstract() {
		return $this->event_abstract;
	}

	function hasEventNote() {
		property_exists($this, 'event_note')
			|| error_die("Missing event_note");

		return isset( $this->event_note );
	}

	function getEventNote() {
		return $this->event_note;
	}

	function getEventNoteHTML($args = []) {
		return Markdown::parse( _( $this->event_note ), $args );
	}

	function getEventDescriptionHTML($args = []) {
		return Markdown::parse( _( $this->event_description ), $args );
	}

	function getEventAbstractHTML($args = []) {
		return Markdown::parse( _( $this->event_abstract ), $args );
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

	function querySharables() {
		return Sharable::queryByEvent( $this->getEventID() );
	}

	/**
	 * @return DynamicQuery
	 */
	function getNextEventsQuery() {
		$q = Event::getStandardQueryEvent();
		$q->appendCondition( sprintf(
			"DATE(event_start) = '%s'",
			esc_sql( $this->getEventStart('Y-m-d') )
		) );
		$q->appendCondition( sprintf(
			'event.conference_ID = %d',
			$this->getConferenceID()
		) );
		$q->appendCondition( sprintf(
			'room.room_ID = %d',
			$this->getRoomID()
		) );
		$q->appendOrderBy('event_start');
		$q->appendCondition( sprintf(
			"event_start >= '%s'",
			esc_sql( $this->getEventEnd() )
		) );
		return $q;
	}

	/**
	 * @return DynamicQuery
	 */
	function getPreviousEventsQuery() {
		$q = Event::getStandardQueryEvent();
		$q->appendCondition( sprintf(
			"DATE(event_start) = '%s'",
			esc_sql( $this->getEventStart('Y-m-d') )
		) );
		$q->appendCondition( sprintf(
			'event.conference_ID = %d',
			$this->getConferenceID()
		) );
		$q->appendCondition( sprintf(
			'room.room_ID = %d',
			$this->getRoomID()
		) );
		$q->appendOrderBy('event_end DESC');
		$q->appendCondition( sprintf(
			"event_end <= '%s'",
			esc_sql( $this->getEventStart() )
		) );
		return $q;
	}

	/**
	 * Get a single Event if exists any next event.
	 */
	function getNextEvent($fields = null) {
		if( ! $fields ) {
			$fields = Event::$FULL_FIELDS;
		}
		if( $next_ID = $this->getSpecifiedNextEventID() ) {
			return Event::getByID( $next_ID, $fields );
		}
		return $this->getNextEventsQuery()->selectField($fields)->setLimit(1)->getRow('Event');
	}

	/**
	 * Get a single Event if exists any previous event.
	 */
	function getPreviousEvent($fields = null) {
		if( ! $fields ) {
			$fields = Event::$FULL_FIELDS;
		}
		if( $previous_ID = $this->getSpecifiedPreviousEventID() ) {
			return Event::getByID( $previous_ID, $fields );
		}
		return $this->getPreviousEventsQuery()->selectField($fields)->setLimit(1)->getRow('Event');
	}

	/**
	 * Insert subscription if not exists
	 */
	function addSubscription($email) {
		$exists = Subscription::getStandardQuery( $email, $this->getEventID() )->getRow('Subscription');

		$exists || Subscription::insert( $email, $this->getEventID() );

		return $exists;
	}

	function areEventSubscriptionsAvailable() {
		isset( $this->event_subscriptions )
			|| error_die("Missing event_subscriptions");

		return $this->event_subscriptions && ! $this->isEventPassed();
	}

	function isEventPassed() {
		$now = new DateTime('now');
		return $now->diff( $this->event_end )->invert === 1;
	}

	/**
	 * The previous event can be specified or not.
	 * @return NULL or int (event_ID)
	 */
	function getSpecifiedPreviousEventID() {
		property_exists($this, 'event_previous')
			|| error_die("Missing event_previous");

		return $this->event_previous;
	}

	/**
	 * The next event can be specified or not.
	 * @return NULL or int (event_ID)
	 */
	function getSpecifiedNextEventID() {
		property_exists($this, 'event_next')
			|| error_die("Missing event_next");

		return $this->event_next;
	}
}

class_exists('User');
class_exists('Conference');
class_exists('Chapter');
class_exists('Room');
class_exists('Track');
class_exists('Location');

class Event {
	use EventTrait, UserTrait, ConferenceTrait, ChapterTrait, RoomTrait, TrackTrait, LocationTrait;

	static $FULL_FIELDS = [
		'event.event_ID',
		'event_uid',
		'event_title',
		'event_subtitle',
		'event_abstract',
		'event_description',
		'event_note',
		'event_language',
		'event_start',
		'event_end',
		'event_img',
		'event_subscriptions',
		'event_next',
		'event_previous',
		'room.room_ID',
		'room_uid',
		'room_name',
		'track_uid',
		'track_name',
		'track_label',
		'chapter_uid',
		'chapter_name',
		'conference.conference_ID',
		'conference_uid',
		'conference_title',
		'location_name',
		'location_lat',
		'location_lon',
		'location_address'
	];

	function __construct() {
		self::normalize($this);
		User::normalize($this);
		Conference::normalize($this);
		Chapter::normalize($this);
		Room::normalize($this);
		Track::normalize($this);
		Location::normalize($this);
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
		if( isset( $t->event_subscriptions ) ) {
			$t->event_subscriptions = (bool) (int) $t->event_subscriptions;
		}
		if( isset( $t->event_next ) ) {
			$t->event_next = (int) $t->event_next;
		}
		if( isset( $t->event_previous) ) {
			$t->event_previous = (int) $t->event_previous;
		}
	}

	static function getByID($event_ID, $fields = [] ) {
		$q = self::getStandardQueryEvent()->appendCondition( sprintf(
			'event.event_ID = %d',
			$event_ID
		) );
		$fields = $fields ? $fields : self::$FULL_FIELDS;
		return $q->selectField($fields)->getRow('Event');
	}

	/**
	 * @return Event
	 */
	static function getByConference( $event_uid, $conference_uid ) {
		return Event::getQueryEventByConference($event_uid, $conference_uid)
		            ->selectField( self::$FULL_FIELDS )->getRow('Event');
	}

	/**
	 * @return Event
	 */
	static function getByConferenceChapter( $event_uid, $conference_uid, $chapter_uid ) {
		return Event::getQueryEventByConferenceChapter($event_uid, $conference_uid, $chapter_uid)
		            ->selectField( self::$FULL_FIELDS )->getRow('Event');
	}

	/**
	 * @return DynamicQuery
	 */
	static function getStandardQueryEvent() {
		$q = new DynamicQuery();
		$q->useTable( [ 'event', 'conference', 'room', 'track', 'chapter', 'location' ] );
		$q->appendCondition('event.conference_ID = conference.conference_ID');
		$q->appendCondition('event.room_ID = room.room_ID');
		$q->appendCondition('event.chapter_ID = chapter.chapter_ID');
		$q->appendCondition('event.track_ID = track.track_ID');
		$q->appendCondition('conference.location_ID = location.location_ID');
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
					'track_label, '.
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
