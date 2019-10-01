<?php
# Linux Day Torino website - classes
# Copyright (C) 2018, 2019 Valerio Bozzolan, Linux Day Torino
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.

// load dependent traits
class_exists( QueryConference::class, true );

/**
 * Class able to query a FullEvent.
 */
class QueryEvent extends Query {

	use QueryConferenceTrait;

	/**
	 * Univoque Event ID column name
	 *
	 * @var
	 */
	protected $EVENT_ID = 'event.event_ID';

	/**
	 * Univoque Chapter ID column name
	 *
	 * @var
	 */
	protected $CHAPTER_ID = 'event.chapter_ID';

	/*
	 * Univoque Conference ID column name
	 *
	 * Used from ConferenceTrait#joinConference()
	 *
	 * @var
	 */
	protected $CONFERENCE_ID = 'event.conference_ID';

	/**
	 * Univoque Track ID column name
	 *
	 * @var
	 */
	protected $TRACK_ID = 'event.track_ID';

	/**
	 * Univoque Room ID column name
	 *
	 * @var
	 */
	protected $ROOM_ID = 'event.room_ID';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->from( Event::T );
		$this->defaultClass( FullEvent::class );
	}

	/**
	 * Where the Event is...
	 *
	 * @return self
	 */
	public function whereEvent( $event ) {
		return $this->whereEventID( $event->getEventID() );
	}

	/**
	 * Where the Event ID is...
	 *
	 * @param  int  $id Event ID
	 * @return self
	 */
	public function whereEventID( $id ) {
		return $this->whereInt( $this->EVENT_ID, $id );
	}

	/**
	 * Limit to a certain User
	 *
	 * @param $user User
	 * @return self
	 */
	public function whereUser( $user ) {
		return $this->joinEventUser()
		            ->whereInt( EventUser::USER_, $user->getUserID() );
	}

	/**
	 * Where the Event UID is this one
	 *
	 * @param  string $uid Event UID
	 * @return self
	 */
	public function whereEventUID( $uid ) {
		return $this->whereStr( Event::UID, $uid );
	}

	/**
	 * Join a table with the Chapter table
	 *
	 * @return self
	 */
	public function joinChapter() {
		return $this->joinOn( 'INNER', 'chapter', 'chapter.chapter_ID' , $this->CHAPTER_ID );
	}

	/**
	 * Join a table with the Track table
	 *
	 * @return self
	 */
	public function joinTrack() {
		return $this->joinOn( 'INNER', Track::T, Track::ID_, $this->TRACK_ID );
	}

	/**
	 * Join a table with the Room table
	 *
	 * @return self
	 */
	public function joinRoom() {
		return $this->joinOn( 'INNER', Room::T, Room::ID_, $this->ROOM_ID );
	}

	/**
	 * Join Events to User IDs
	 *
	 * You can call it multiple time safely.
	 *
	 * @return self
	 */
	public function joinEventUser() {
		if( empty( $this->joinedEventUser ) ) {
			$this->from(   EventUser::T                  );
			$this->equals( EventUser::EVENT_, Event::ID_ );
			$this->joinedEventUser = true;
		}
		return $this;
	}

	/**
	 * Join Events and their Track, Chapter and Room (can be NULL).
	 *
	 * You can call it multiple time safely.
	 *
	 * @return self
	 */
	public function joinTrackChapterRoom() {
		if( empty( $this->joinedTrackChapterRoom ) ) {

			$this->from(   Room::T )
			     ->equals( Room::ID_,    Event::ROOM_ );

			$this->from(   Track::T )
			     ->equals( Track::ID_,   Event::TRACK_ );

			$this->from(   Chapter::T )
			     ->equals( Chapter::ID_, Event::CHAPTER_ );

			$this->joinedTrackChapterRoom = true;
		}
		return $this;
	}

}
