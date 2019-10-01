<?php
# Linux Day 2016 - Construct a database room
# Copyright (C) 2016, 2017, 2018 Valerio Bozzolan, Linux Day Torino
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

	/**
	 * Get room ID
	 *
	 * @return int
	 */
	public function getRoomID() {
		return $this->get( Room::ID );
	}

	/**
	 * Get room UID
	 *
	 * @return string
	 */
	public function getRoomUID() {
		return $this->get( Room::UID );
	}

	/**
	 * Get localized room name
	 *
	 * @return string
	 */
	public function getRoomName() {
		return __( $this->get( ROOM::NAME ) );
	}

	/**
	 * Normalize a Room object
	 */
	protected function normalizeRoom() {
		$this->integers( Room::ID );
	}
}

/**
 * A Room host Talks and it's in a Location
 */
class Room extends Queried {
	use RoomTrait;

	/**
	 * Database table name
	 */
	const T = 'room';

	/**
	 * Maximum UID length
	 *
	 * @override Queried::MAXLEN_UID
	 */
	const MAXLEN_UID = 64;

	/**
	 * Room ID column
	 */
	const ID = 'room_ID';

	/**
	 * Room UID column
 	 */
	const UID = 'room_uid';

	/**
	 * Room name column
	 */
	const NAME = 'room_name';

	/**
	 * Complete ID column name
	 */
	const ID_ = self::T . DOT . self::ID;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->normalizeRoom();
	}

	/**
	 * All the public room fields
	 *
	 * @return string
	 */
	public static function fields() {
		return Room::T . DOT . STAR;
	}
}
