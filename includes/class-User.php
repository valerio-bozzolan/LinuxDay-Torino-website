<?php
# Linux Day 2016 - Construct a database user
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

trait UserTrait {

	/**
	 * Get the user ID
	 *
	 * @return int
	 */
	public function getUserID() {
		return $this->nonnull( User::ID );
	}

	/**
	 * Get the user UID
	 *
	 * @return string
	 */
	public function getUserUID() {
		return $this->get( User::UID );
	}

	/**
	 * Get the user e-mail
	 *
	 * @return string
	 */
	public function getUserEmail() {
		return $this->getUserUID();
	}

	/**
	 * N.B. Also if he is logged he's public.
	 *
	 * @return bool
	 */
	public function isUserPublic() {
		return $this->get( User::IS_PUBLIC ) || $this->isUserMyself();
	}

	/**
	 * Get the user full name
	 *
	 * @return string
	 */
	public function getUserFullname() {
		return sprintf(
			__("%s %s"),
			$this->get( User::NAME ),
			$this->get( User::SURNAME )
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
			sprintf( __("Profilo utente di %s"), $name ),
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

	/**
	 * It has an user bio?
	 *
	 * @return bool
	 */
	public function hasUserBio() {
		return null !== $this->get('user_bio');
	}

	function getUserBio() {
		return $this->get('user_bio');
	}

	function getUserBioHTML($args = []) {
		return Markdown::parse( __( $this->getUserBIO() ), $args);
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

	/**
	 * Can you edit this user?
	 *
	 * @return bool
	 */
	public function hasPermissionToEditUser() {
		if( has_permission('edit-users') ) {
			return true;
		}
		if( has_permission('edit-account') && $this->isUserMyself() ) {
			return true;
		}
		return false;
	}

	/**
	 * Is this user myself?
	 *
	 * @return bool
	 */
	public function isUserMyself() {
		return is_logged() && get_user()->getUserID() === $this->getUserID();
	}

	function hasUserLovelicense() {
		return null !== $this->get( 'user_lovelicense' );
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

	/**
	 * Normalize a User object
	 */
	protected function normalizeUser() {
		$this->integers( User::ID );
		$this->booleans(
			User::IS_PUBLIC,
			User::IS_ACTIVE
		);
	}
}

class User extends Sessionuser {
	use UserTrait;

	/**
	 * Name column
	 */
	const NAME = 'user_name';

	/**
	 * ID column
	 */
	const SURNAME = 'user_surname';

	/**
	 * He/she public column
	 */
	const IS_PUBLIC = 'user_public';

	/**
	 * Maximum UID length
	 */
	const MAXLEN_UID = 20;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->normalizeUser();
	}

	/**
	 * Factory users by an event
	 *
	 * @param $event_ID int
	 * @return Query
	 */
	public static function factoryByEvent( $event_ID ) {
		return self::factory()
			->from('event_user')
			->equals('event_user.user_ID', 'user.user_ID')
			->whereInt('event_user.event_ID', $event_ID );
	}
}
