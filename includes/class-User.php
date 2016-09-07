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
		if( isset( $t->user_lovelicense ) ) {
			$t->user_lovelicense = license( $t->user_lovelicense );
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

	function queryUserEvents() {
		return query( Event::getQueryUserEvents($this->user_ID) );
	}

	function queryUserSkills() {
		return query( Skill::getQueryUserSkills( $this->user_ID ) );
	}

	function getUserEvents() {
		return query_results( Event::getQueryUserEvents($this->user_ID), 'Event');
	}

	function getUserSkills() {
		return query_results( Skill::getQueryUserSkills( $this->user_ID ), 'Skill');
	}

	function getUserImageURL() {
		return 'https://www.gravatar.com/avatar/' . md5( $this->user_email );
	}


	function getUserBio() {
		$field = "user_bio_" . ISO_LANG;
		return isset( $this->{$field} ) ? $this->{$field} : null;
	}

	// asd!
	function hasUserBio() {
		return nl2br( $this->getUserBio() );
	}

	function isUserSocial() {
		return isset( $this->user_rss )
		    || isset( $this->user_fb )
		    || isset( $this->user_lnkd )
		    || isset( $this->user_googl )
		    || isset( $this->user_twtr );
	}

	function getUserFacebruck() {
		return 'https://facebook.com/' . $this->user_fb;
	}

	function getUserGuggolpluz() {
		return 'https://plus.google.com/' . $this->user_googl;
	}

	function getUserTuitt() {
		return 'https://twitter.com/' . $this->user_twtr;
	}

	function getUserLinkeddon() {
		return 'https://www.linkedin.com/in/' . $this->user_lnkd;
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
