<?php
# Linux Day 2016 - Homepage
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

class_exists('User');
class_exists('Talk');

/**
 * Reletion between users and talks.
 */
class Talker {
	use TalkTrait;
	use UserTrait;

	static function queryTalkers() {
		return query_results(
			"SELECT ".
				"talk.talk_type, ".
				"talk.talk_uid, ".
				"talk.talk_hour, ".
				"talk.talk_title, ".
				"user.user_uid, ".
				"user.user_name, ".
				"user.user_surname".
			" FROM ".
				$GLOBALS[JOIN]('talker', 'talk', 'user').
			" WHERE ".
				"talker.talk_ID = talk.talk_ID AND ".
				"talker.user_ID = user.user_ID ".
			" ORDER BY ".
				"talk.talk_hour",
			'Talker'
		);
	}

	function __construct() {
		self::prepareTalk($this);
		self::prepareUser($this);
	}
}
