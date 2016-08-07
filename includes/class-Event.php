<?php
# Linux Day 2016 - Construct a database event
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

trait EventTrait {
	static function prepareEvent(& $t) {
		if( isset( $t->event_ID ) ) {
			$t->event_ID   = (int) $t->event_ID;
		}

		// MySQL datetime to PHP DateTime
		if( isset( $t->event_start ) ) {
			datetime2php($t->event_start);
		}

		// MySQL datetime to PHP DateTime
		if( isset( $t->event_end ) ) {
			datetime2php($t->event_end);
		}
	}
}

class Event {
	use EventTrait;

	function __construct() {
		self::prepareEvent($this);
	}
}
