<?php
# Linux Day Torino website - classes
# Copyright (C) 2016, 2017, 2018, 2019 Valerio Bozzolan, Linux Day Torino contributors
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
class_exists( 'QueryEvent', true );
class_exists( 'QueryUser',  true );

/**
 * Class able to query a QueryEventUser
 */
trait QueryEventUserTrait {

	use QueryEventTrait;
	use QueryUserTrait;

	/*
	 * Univoque User ID column name
	 *
	 * Used from EventUserTrait.
	 *
	 * @var
	 */
	protected $USER_ID = 'event_user.user_ID';

	/*
	 * Univoque Event ID column name
	 *
	 * Used from EventUserTrait.
	 *
	 * @var
	 */
	protected $EVENT_ID = 'event_user.event_ID';

	/**
	 * Limit to a specific EventUser
	 *
	 * @param $event_user EventUser
	 * @return self
	 */
	public function whereEventUser( $event_user ) {
		return $this->whereEvent( $event_user )
		            ->whereUser(  $event_user );
	}

}

/**
 * Query an EventUser
 */
class QueryEventUser extends Query {

	use QueryEventUserTrait;

	/**
	 * Constructor
	 */
	public function __construct( $db = null ) {

		// set database connection and default result class
		parent::__construct( $db, EventUser::class );

		// set the default table
		$this->from( EventUser::T );
	}

}
