<?php
# Linux Day 2016 - Construct a database user
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

trait UserTrait {
	static function prepareUser(& $t) {
		if( isset( $t->user_ID ) ) {
			$t->user_ID = (int) $t->user_ID;
		}
	}

	function getUserFullname() {
		return sprintf(
			_("%s %s"),
			$this->user_name,
			$this->user_surname
		);
	}

	function getUserProfileURL() {
		return URL . '/people/' . $this->user_uid;
	}

	function getUserProfileLink($html_class = null) {
		$name = $this->getUserFullname();

		return HTML::a(
			$this->getUserProfileURL(),
			$name,
			sprintf(
				_("Profilo utente di %s"),
				$name
			),
			$html_class
		);
	}

	function getUserEvents() {
		global $JOIN;

		return query_results(
			sprintf(
				'SELECT '.
					'event_uid, '.
					'event_title, '.
					'event_start, '.
					'event_end '.
					"FROM {$JOIN('event', 'event_user')} " .
				'WHERE '.
					'event_user.user_ID = %d AND '.
					'event_user.event_ID = event.event_ID '.
				'ORDER BY '.
					'event_start'
				,
				$this->user_ID
			),
			'Event'
		);
	}

	function queryUserSkills() {
		global $JOIN;

		return query(
			sprintf(
				'SELECT '.
					'skill_uid, '.
					'skill_title, ' .
					'skill_score ' .
					"FROM {$JOIN('user_skill', 'skill')} ".
				'WHERE '.
					'user_skill.user_ID = %d AND '.
					'user_skill.skill_ID = skill.skill_ID ' .
				'ORDER BY '.
					'skill_score < 0, '.
					'ABS(skill_score)'
				,
				$this->user_ID
			),
			'Skill'
		);
	}

	function getUserImageURL() {
		return 'https://www.gravatar.com/avatar/' . md5( $this->user_email );
	}
}

class User {
	use UserTrait;

	function __construct() {
		self::prepareUser($this);
	}

	static function queryUser($uid) {
		global $T;

		return query_row(
			sprintf(
				"SELECT * FROM {$T('user')} WHERE user_uid = '%s'",
				esc_sql( $uid )
			),
			'User'
		);
	}
}
