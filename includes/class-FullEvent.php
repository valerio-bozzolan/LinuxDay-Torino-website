<?php
# Linux Day 2016 - Construct a database event (full of relations)
# Copyright (C) 2016, 2017, 2018 Valerio Bozzolan, Ludovico Pavesi, Linux Day Torino
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
		return $base . FullEvent::permalink(
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

/**
 * An Event with all the bells and whistles
 */
class FullEvent extends Queried {
	use FullEventTrait;
	use EventTrait;
	use ConferenceTrait;
	use ChapterTrait;
	use RoomTrait;
	use TrackTrait;

	public function __construct() {
		$this->normalizeEvent();
		$this->normalizeConference();
		$this->normalizeChapter();
		$this->normalizeRoom();
		$this->normalizeTrack();
	}

	/**
	 * Query constructor
	 *
	 * @return Query
	 */
	public static function factory() {
		return Query::factory( __CLASS__ )
			->from( [
				Event     ::T,
				Conference::T,
				Room      ::T,
				Track     ::T,
				Chapter   ::T,
			] )
			->equals( Event::CONFERENCE_, Conference::ID_ )
			->equals( Event::ROOM_,       Room      ::ID_ )
			->equals( Event::TRACK_,      Track     ::ID_ )
			->equals( Event::CHAPTER_,    Chapter   ::ID_ );
	}

	static function factoryByConference( $conference_ID ) {
		return self::factory()
			->whereInt( Event::CONFERENCE_, $conference_ID );
	}

	static function factoryByConferenceAndUID( $conference_ID, $event_uid ) {
		$event_uid = Event::sanitizeUID( $event_uid );

		return self::factoryByConference( $conference_ID )
			->whereStr( Event::UID, $event_uid );
	}

	static function queryByConferenceAndUID( $conference_ID, $event_uid ) {
		return self::factoryByConferenceAndUID( $conference_ID, $event_uid )
			->queryRow();
	}

	static function factoryByUser( $user_ID ) {
		return self::factory()
			->from(     EventUser::T                  )
			->equals(   EventUser::EVENT_, Event::ID_ )
			->whereInt( EventUser::USER_,  $user_ID   )
			->orderBy(  EventUser::ORDER              );
	}

	static function factoryByConferenceChapter( $conference_ID, $chapter_ID ) {
		return self::factoryByConference( $conference_ID )
			->whereInt( Event::CHAPTER_, $chapter_ID );
	}

	/**
	 * Get an absolute FullEvent permalink
	 *
	 * @param $conference_uid string Conference UID
	 * @param $event_uid string Event UID
	 * @param $chapter_uid string Chapter UID
	 */
	public static function permalink( $conference_uid, $event_uid, $chapter_uid ) {
		return sprintf( PERMALINK_EVENT, $conference_uid, $event_uid, $chapter_uid ) ;

	}
}
