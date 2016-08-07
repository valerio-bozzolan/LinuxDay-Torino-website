<?php
# Linux Day 2016 - Construct a database conference
# Copyright (C) 2016 Valerio Bozzolan
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

trait ConferenceTrait {
	static function prepareConference(& $t) {
		if( isset( $t->conference_ID ) ) {
			$t->conference_ID   = (int) $t->conference_ID;
		}

		// MySQL datetime to PHP DateTime
		if( isset( $t->conference_start ) ) {
			datetime2php($t->conference_start);
		}

		// MySQL datetime to PHP DateTime
		if( isset( $t->conference_end ) ) {
			datetime2php($t->conference_end);
		}
	}
}

class Conference {
	use ConferenceTrait;

	function __construct() {
		self::prepareConference($this);
	}
}
