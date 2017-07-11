<?php
# Linux Day 2016 - Construct a database conference (full of relations)
# Copyright (C) 2016, 2017 Valerio Bozzolan, Linux Day Torino
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

class_exists('Conference');
class_exists('Location');

class FullConference extends Queried {
	use ConferenceTrait;
	use LocationTrait;

	function __construct() {
		$this->normalizeConference();
		$this->normalizeLocation();
	}

	static function factory() {
		return Query::factory( __CLASS__ )
			->from( 'conference', 'location' )
			->equals( 'conference.location_ID', 'location.location_ID' );
	}

	static function factoryByUID( $conference_uid ) {
		$conference_uid = Conference::sanitizeUID( $conference_uid );

		return self::factory()
			->whereStr( 'conference_uid', $conference_uid );
	}

	static function queryByUID( $conference_uid ) {
		return self::factoryByUID( $conference_uid )->queryRow();
	}
}
