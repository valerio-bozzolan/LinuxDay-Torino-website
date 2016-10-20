<?php
# Linux Day 2016 - Construct a database track
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

trait TrackTrait {
	function getTrackID() {
		isset( $this->track_ID )
			|| error_die("Missing track_ID");

		return $this->room_ID;
	}

	function getTrackUID() {
		isset( $this->track_uid )
			|| error_die("Missing track_uid");

		return $this->track_uid;
	}

	function getTrackName() {
		return _( $this->track_name );
	}

	function getTrackLabel() {
		return _( $this->track_label );
	}
}

class Track {
	use TrackTrait;

	function __construct() {
		self::normalize($this);
	}

	static function normalize(& $t) {
		if( isset( $t->track_ID ) ) {
			$t->track_ID = (int) $t->track_ID;
		}
	}

	static function getTrack($uid) {
		global $T;

		return query_row(
			sprintf(
				"SELECT * FROM {$T('track')} WHERE track_uid = '%s'",
				esc_sql( luser_input( $uid, 32) )
			),
			'Track'
		);
	}
}
