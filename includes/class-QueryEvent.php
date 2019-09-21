<?php
# Linux Day Torino website - classes
# Copyright (C) 2018 Valerio Bozzolan, Linux Day Torino
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

/**
 * Class able to query a FullEvent.
 */
class QueryEvent extends Query {

	/**
	 * Univoque Chapter ID column name
	 *
	 * @var
	 */
	protected $CHAPTER_ID = 'event.chapter_ID';

	/**
	 * Univoque location ID column name (useful with conference joins)
	 */
	protected $LOCATION_ID = 'conference.location_ID';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->from( Event::T );
		$this->defaultClass( FullEvent::class );
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
	 * Limit to a specific Conference
	 *
	 * @param $conference Conference
	 * @return self
	 */
	public function whereConference( $conference ) {
		return $this->joinConference()
		            ->whereInt( Event::CONFERENCE_, $conference->getConferenceID() );
	}

	/**
	 * Exclude a specific Conference
	 *
	 * @param $conference Conference
	 * @return self
	 */
	public function whereConferenceNot( $conference ) {
		$id = $conference->getConferenceID();
		return $this->joinConference()
		            ->whereInt( Event::CONFERENCE_, $id, '<>' );
	}

	/**
	 * Join Events to their Conference
	 *
	 * You can call it multiple time safely.
	 *
	 * @return self
	 */
	public function joinConference() {
		if( empty( $this->joinedConference ) ) {
			$this->from(   Conference::T                       );
			$this->equals( Conference::ID_, Event::CONFERENCE_ );
			$this->joinedConference = true;
		}
		return $this;
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
	 * Join Events to their Location (and Conference. asd)
	 *
	 * You can call it multiple time safely.
	 *
	 * @TODO: move this method into QueryConference, and extends QueryEvent
	 * @return self
	 */
	public function joinLocation() {
		if( empty( $this->joinedLocation ) ) {
			$this->joinOn( 'INNER', Location::T, $this->LOCATION_ID, 'location.location_ID' );
		}
		return $this;
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
