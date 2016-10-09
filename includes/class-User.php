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
	function getUserID() {
		isset( $this->user_ID )
			|| error_die("Missing user_ID");

		return $this->user_ID;
	}

	function getUserUID() {
		isset( $this->user_uid )
			|| error_die("Missing user_uid");

		return $this->user_uid;
	}

	/**
	 * N.B. Also if he is logged he's public.
	 */
	function isUserPublic() {
		isset( $this->user_public )
			|| die("Missing user_public");

		$user_ID = $this->getUserID();

		return $this->user_public || get_user('user_ID') === $user_ID;
	}

	function getUserFullname() {
		return sprintf(
			_("%s %s"),
			$this->user_name,
			$this->user_surname
		);
	}

	function getUserURL() {
		return URL . sprintf( PERMALINK_USER, $this->getUserUID() );
	}

	function forceUserPermalink() {
		$url = $this->getUserURL();
		if( $url !== request_uri() ) {
			http_redirect( $url );
		}
	}

	function getUserLink($html_class = null) {
		$name = $this->getUserFullname();

		return HTML::a(
			$this->getUserURL(),
			$name,
			sprintf(
				_("Profilo utente di %s"),
				$name
			),
			$html_class
		);
	}

	function queryUserSkills() {
		return query( Skill::getQueryUserSkills( $this->user_ID ) );
	}

	function getUserEvents() {
		return query_results( Event::getQueryUserEvents( $this->user_ID ), 'Event');
	}

	function getUserSkills() {
		return query_results( Skill::getQueryUserSkills( $this->user_ID ), 'Skill');
	}

	function getUserEmail() {
		property_exists($this, 'user_email')
			|| error_die("Missing user_email");

		return $this->user_email;
	}

	function getUserImage($s = 256) {
		property_exists($this, 'user_image')
			|| error_die("Missing user_image");

		$image = $this->user_image;
		if( ! $image ) {
			$image = 'https://www.gravatar.com/avatar/' . md5( $this->getUserEmail() ) . '?s=' . $s;
		}

		return $image;
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

	function getUserGithubbo() {
		return 'https://github.com/' . $this->user_github;
	}

	private function getQueryUserEvents() {
		$q = Event::getStandardQueryEvent();
		$q->useTable('event_user');
		$q->appendCondition('event.event_ID = event_user.event_ID');
		$q->appendCondition(
			sprintf(
				'event_user.user_ID = %d',
				$this->getUserID()
			)
		);
		return $q;
	}

	private function getQueryUserEventsByConference($conference_ID) {
		$q = $this->getQueryUserEvents();
		$q->useTable('event');
		$q->appendCondition('event_user.event_ID = event.event_ID');
		return $q->appendCondition(
			sprintf(
				'event.conference_ID = %d',
				$conference_ID
			)
		);
	}

	function queryUserEvents() {
		return $this->getQueryUserEvents()->query();
	}

	function queryUserEventsByConference($conference_ID) {
		return $this->getQueryUserEventsByConference($conference_ID)->query();
	}

	function hasPermissionToEditUser() {
		if( has_permission('edit-users') ) {
			return true;
		}
		if( has_permission('edit-account') && $this->isUserMyself() ) {
			return true;
		}
		return false;
	}

	function isUserMyself() {
		return get_user('user_ID') === $this->getUserID();
	}
}

class_exists('Sessionuser');

class User {
	use UserTrait, SessionuserTrait;

	function __construct() {
		self::normalize($this);
	}

	static function normalize(& $t) {
		if( isset( $t->user_ID ) ) {
			$t->user_ID = (int) $t->user_ID;
		}
		if( isset( $t->user_lovelicense ) ) {
			$t->user_lovelicense = license( $t->user_lovelicense );
		}
		if( isset( $t->user_public ) ) {
			$t->user_public = (bool) (int) $t->user_public;
		}
	}

	static function getUser($uid) {
		global $T;

		return query_row(
			sprintf(
				"SELECT * FROM {$T('user')} WHERE user_uid = '%s'",
				esc_sql( luser_input( $uid, 32) )
			),
			'User'
		);
	}

	/**
	 * Return DynamicQuery
	 */
	static function getStandardQueryUsers() {
		$q = new DynamicQuery();
		return $q->useTable('user');
	}

	/**
	 * @return DynamicQuery
	 */
	static function getQueryUsersByEvent( $event_ID ) {
		$q = self::getStandardQueryUsers();
		$q->useTable('event_user');
		$q->appendCondition('event_user.user_ID = user.user_ID');
		$q->appendCondition( sprintf(
			'event_user.event_ID = %d',
			$event_ID
		) );
		return $q->appendOrderBy('event_user_order');
	}
}
