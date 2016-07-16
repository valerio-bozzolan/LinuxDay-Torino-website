<?php
# Linux Day 2016 - Instantiate database talk row
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

trait TalkTrait {
	static function prepareTalk(& $t) {
		if( isset( $t->talk_hour ) ) {
			$t->talk_hour = (int) $t->talk_hour;
		}
	}

	function getTalkUsers() {
		isset( $this->talk_ID ) ||
			error_die("Unset talk_ID");

		return query_results(
			sprintf(
				"SELECT " .
					"user.user_uid, ".
					"user.user_name, ".
					"user.user_surname".
				" FROM ".
					$GLOBALS[JOIN]('talker', 'user').
				" WHERE ".
					"talker.talk_ID = %d AND ".
					"talker.user_ID = user.user_ID"
				,
				$this->talk_ID
			)
		);
	}
}

class Talk {
	use TalkTrait;

	function __construct() {
		self::prepareTalk( $this );
	}
}
