<?php
# Linux Day 2016 - Construct a database event (full of relations)
# Copyright (C) 2016, 2017 Valerio Bozzolan, Ludovico Pavesi, Linux Day Torino
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

class_exists('Event');
class_exists('Conference');
class_exists('Room');
class_exists('Chapter');
class_exists('Track');

trait FullEventTrait {
	function getEventURL( $base = URL ) {
		return $base . sprintf(
			PERMALINK_EVENT,
			$this->getConferenceUID(),
			$this->getEventUID(),
			$this->getChapterUID()
		);
	}

	function forceEventPermalink() {
		$url = $this->getEventURL( ROOT );
		if( $url !== $_SERVER['REQUEST_URI'] ) {
			http_redirect( $url );
		}
	}

	function factoryNextFullEvent() {
		return $this->factoryFullEventInSameContext()
			->where( sprintf(
				"event_start >= '%s'",
				esc_sql( $this->getEventEnd('Y-m-d H:i:s') )
			) )
			->orderBy('event_start');
	}

	function factoryPreviousFullEvent() {
		return $this->factoryFullEventInSameContext()
			->where( sprintf(
				"event_end <= '%s'",
				esc_sql( $this->getEventStart('Y-m-d H:i:s') )
			) )
			->orderBy('event_end DESC');
	}

	private function factoryFullEventInSameContext() {
		return FullEvent::factory()
			->whereInt( 'event.conference_ID', $this->getConferenceID() )
			->whereInt( 'event.room_ID',       $this->getRoomID() );
	}
}

class FullEvent extends Queried {
	use FullEventTrait;
	use EventTrait;
	use ConferenceTrait;
	use ChapterTrait;
	use RoomTrait;
	use TrackTrait;

	function __construct() {
		$this->normalizeEvent();
		$this->normalizeConference();
		$this->normalizeChapter();
		$this->normalizeRoom();
		$this->normalizeTrack();
	}

	static function factory() {
		return Query::factory( __CLASS__ )
			->from(
				'event',
				'conference',
				'room',
				'track',
				'chapter'
			)
			->equals('event.conference_ID', 'conference.conference_ID')
			->equals('event.room_ID',       'room.room_ID')
			->equals('event.track_ID',      'track.track_ID')
			->equals('event.chapter_ID',    'chapter.chapter_ID');
	}

	static function factoryByConference( $conference_ID ) {
		return self::factory()
			->whereInt( 'event.conference_ID', $conference_ID );
	}

	static function factoryByConferenceAndUID( $conference_ID, $event_uid ) {
		$event_uid = Event::sanitizeUID( $event_uid );

		return self::factoryByConference( $conference_ID )
			->whereStr( 'event_uid', $event_uid );
	}

	static function queryByConferenceAndUID( $conference_ID, $event_uid ) {
		return self::factoryByConferenceAndUID( $conference_ID, $event_uid )
			->queryRow();
	}


	static function factoryByUser( $user_ID ) {
		return self::factory()
			->from('event_user')
			->equals('event_user.event_ID', 'event.event_ID')
			->whereInt( 'event_user.user_ID', $user_ID )
			->orderBy('event_user_order');
	}

	static function factoryByConferenceChapter( $conference_ID, $chapter_ID ) {
		return self::factoryByConference( $conference_ID )
			->whereInt( 'event.chapter_ID', $chapter_ID );
	}
}
