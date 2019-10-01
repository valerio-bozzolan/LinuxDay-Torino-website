<?php
# Linux Day 2016 - Construct a database conference (full of relations)
# Copyright (C) 2016, 2017, 2018, 2019 Valerio Bozzolan, Linux Day Torino
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

class_exists( 'Conference' );
class_exists( 'Location' );

/**
 * A conference with all the bells and whistles
 */
class FullConference extends Queried {
	use ConferenceTrait;
	use LocationTrait;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->normalizeConference();
		$this->normalizeLocation();
	}

	/**
	 * Query constructor
	 *
	 * @return Query
	 */
	public static function factory() {
		return ( new QueryConference() )
			->joinLocation()
			->defaultClass( __CLASS__ );
	}

	/**
	 * Query constructor from a certain Conference UID
	 *
	 * @param $conference_uid string Conference UID
	 * @return Query
	 */
	public static function factoryFromUID( $conference_uid ) {
		$conference_uid = Conference::sanitizeUID( $conference_uid );
		return self::factory()
			->whereStr( Conference::UID, $conference_uid );
	}
}
