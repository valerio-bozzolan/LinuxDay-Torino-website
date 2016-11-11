<?php
# Linux Day 2016 - Construct a database room
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

trait RoomTrait {
	function getRoomID() {
		isset( $this->room_ID )
			|| error_die("Missing room_ID");

		return $this->room_ID;
	}

	function getRoomUID() {
		isset( $this->room_uid )
			|| error_die("Missing room_uid");

		return $this->room_uid;
	}

	function getRoomName() {
		return _( $this->room_name );
	}
}

class Room {
	use RoomTrait;

	function __construct() {
		self::normalize($this);
	}

	static function normalize(& $t) {
		if( isset( $t->room_ID ) ) {
			$t->room_ID = (int) $t->room_ID;
		}
	}

	static function get($uid) {
		global $T;

		return query_row(
			sprintf(
				"SELECT * FROM {$T('room')} WHERE room_uid = '%s'",
				esc_sql( luser_input( $uid, 32) )
			),
			'Room'
		);
	}
}
