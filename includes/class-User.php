<?php
# Linux Day 2016 - Construct a database user
# Copyright (C) 2016, 2017 Valerio Bozzolan, Linux Day Torino
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
		return $this->nonnull('user_ID');
	}

	function getUserUID() {
		return $this->get('user_uid');
	}

	function getUserEmail() {
		return $this->get('user_email');
	}

	/**
	 * N.B. Also if he is logged he's public.
	 */
	function isUserPublic() {
		return $this->get('user_public') || $this->isUserMyself();
	}

	function getUserFullname() {
		return sprintf(
			_("%s %s"),
			$this->get('user_name'),
			$this->get('user_surname')
		);
	}

	function getUserURL( $base = ROOT ) {
		return $base . sprintf( PERMALINK_USER,
			CURRENT_CONFERENCE_UID,
			$this->getUserUID()
		);
	}

	function forceUserPermalink() {
		$url = $this->getUserURL( ROOT );
		if( $url !== $_SERVER['REQUEST_URI'] ) {
			http_redirect( $url );
		}
	}

	function getUserLink( $base = null, $html_class = null) {
		$name = $this->getUserFullname();

		return HTML::a(
			$this->getUserURL( $base ),
			$name,
			sprintf( _("Profilo utente di %s"), $name ),
			$html_class
		);
	}

	function getUserImage($s = 256) {
		$image = $this->get('user_image');
		if( ! $image ) {
			$image = 'https://www.gravatar.com/avatar/' . md5( $this->getUserEmail() ) . '?s=' . $s;
		}
		return $image;
	}

	function hasUserBio() {
		return null !== $this->get('user_bio');
	}

	function getUserBio() {
		return $this->get('user_bio');
	}

	function getUserBioHTML($args = []) {
		return Markdown::parse( _( $this->getUserBIO() ), $args);
	}

	function isUserSocial() {
		return
			null !== $this->get('user_rss')   ||
			null !== $this->get('user_fb')    ||
			null !== $this->get('user_lnkd')  ||
			null !== $this->get('user_googl') ||
			null !== $this->get('user_twtr')  ||
			null !== $this->get('user_github');
	}

	function getUserFacebruck() {
		return 'https://facebook.com/' . $this->get('user_fb');
	}

	function getUserGuggolpluz() {
		return 'https://plus.google.com/' . $this->get('user_googl');
	}

	function getUserTuitt() {
		return 'https://twitter.com/' . $this->get('user_twtr');
	}

	function getUserLinkeddon() {
		return 'https://www.linkedin.com/in/' . $this->get('user_lnkd');
	}

	function getUserGithubbo() {
		return 'https://github.com/' . $this->get('user_github');
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
		return is_logged() && get_user()->getUserID() === $this->getUserID();
	}

	function hasUserLovelicense() {
		property_exists($this, 'user_lovelicense')
			|| error_die("Missing user_lovelicense");

		return isset( $this->user_lovelicense );
	}

	function getUserLovelicense() {
		return license( $this->user_lovelicense );
	}

	function factoryUserSkills() {
		return UserSkill::factorySkillByUser( $this->getUserID() );
	}

	function factoryUserEvents() {
		return FullEvent::factoryByUser( $this->getUserID() );
	}

	private function normalizeUser() {
		$this->integers('user_ID');
		$this->booleans(
			'user_public',
			'user_acrive'
		);
	}
}

// From Boz-PHP
class_exists('Sessionuser');

class User extends Queried {
	use UserTrait;

	// From Boz-PHP
	use SessionuserTrait;

	function __construct() {
		$this->normalizeUser();
	}

	static function factory() {
		return Query::factory( __CLASS__ )
			->from('user');
	}

	static function factoryByEvent( $event_ID ) {
		return self::factory()
			->from('event_user')
			->equals('event_user.user_ID', 'user.user_ID')
			->whereInt('event_user.event_ID', $event_ID );
	}

	static function factoryByUID( $user_uid ) {
		$user_uid = self::sanitizeUID( $user_uid );
		return self::factory()
			->whereStr( 'user_uid', $user_uid );
	}

	static function queryByUID( $user_uid ) {
		return self::factoryByUID( $user_uid )
			->queryRow();
	}

	private static function sanitizeUID( $user_uid ) {
		return luser_input( $user_uid, 20 );
	}
}
