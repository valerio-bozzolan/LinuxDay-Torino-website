<?php
# Linux Day Torino website - classes
# Copyright (C) 2019 Valerio Bozzolan, Linux Day Torino
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
 * Class able to query a Conference
 */
trait QueryConferenceTrait {

	/*
	 * Univoque Location ID column name
	 *
	 * Used from ConferenceTrait.
	 *
	 * @var
	 */
	protected $LOCATION_ID = 'conference.location_ID';

	/**
	 * Limit to a specific Conference
	 *
	 * @param $conference Conference
	 * @return self
	 */
	public function whereConference( $conference ) {
		return $this->whereInt( $this->CONFERENCE_ID, $conference->getConferenceID() );
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
	 * Where the Conference UID is...
	 *
	 * @param  string $uid Conference UID
	 * @return self
	 */
	public function whereConferenceUID( $uid ) {
		return $this->whereStr( Conference::UID, $uid );
	}

	/**
	 * Join a table to the Conference table
	 *
	 * You can call it multiple time safely.
	 *
	 * @return self
	 */
	public function joinConference() {
		if( empty( $this->joinedConference ) ) {
			$this->joinOn( 'INNER', Conference::T, Conference::ID_, $this->CONFERENCE_ID );
			$this->joinedConference = true;
		}
		return $this;
	}

	/**
	 * Join Events to their Location (and Conference. asd)
	 *
	 * You can call it multiple time safely.
	 *
	 * @return self
	 */
	public function joinLocation() {
		if( empty( $this->joinedLocation ) ) {
			$this->joinOn( 'INNER', Location::T, $this->LOCATION_ID, 'location.location_ID' );
			$this->joinedLocation = true;
		}
		return $this;
	}

}

/**
 * Conference
 */
class QueryConference extends Query {

	use QueryConferenceTrait;

	/*
	 * Univoque Conference ID column name
	 *
	 * Used from ConferenceTrait.
	 *
	 * @var
	 */
	protected $CONFERENCE_ID = 'conference.conference_ID';

	/**
	 * Constructor
	 */
	public function __construct( $db = null ) {

		// set database connection and default result class
		parent::__construct( $db, Conference::class );

		// set the default table
		$this->from( Conference::T );
	}

}
