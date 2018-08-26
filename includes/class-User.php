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
	 * Check if the user is public
	 *
	 * @return bool
	 */
	public function isUserPublic() {
		return $this->get( User::IS_PUBLIC );
	}

	/**
	 * Check if I can see this user
	 *
	 * @return bool
	 */
	public function isUserVisible() {
		return $this->isUserPublic() || $this->isUserMyself();
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

	/**
	 * Get the URL of the user image
	 *
	 * @param $s int Suggested width
	 * @return string
	 */
	public function getUserImage( $s = 256 ) {
		$image = $this->get( User::IMAGE );
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

	/**
	 * Check if the user is somehow social
	 *
	 * @return bool
	 */
	public function isUserSocial() {
		foreach( User::allSocialFields() as $field ) {
			if( $this->has( $field ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Get the user Facebook profile URL
	 *
	 * @return string URL
	 */
	public function getUserFacebruck() {
		return 'https://facebook.com/' . $this->get( User::FACEBOOK );
	}

	/**
	 * Get the user Google+ profile URL
	 *
	 * @return string URL
	 */
	public function getUserGuggolpluz() {
		return 'https://plus.google.com/' . $this->get( User::GOOGLE_PLUS );
	}

	/**
	 * Get the user Twitter profile URL
	 *
	 * @return string URL
	 */
	public function getUserTuitt() {
		return 'https://twitter.com/' . $this->get( User::TWITTER );
	}

	/**
	 * Get the user Linkedin profile URL
	 *
	 * @return string URL
	 */
	public function getUserLinkeddon() {
		return 'https://www.linkedin.com/in/' . $this->get( User::LINKEDIN );
	}

	/**
	 * Get the user GitHub profile URL
	 *
	 * @return string URL
	 */
	public function getUserGithubbo() {
		return 'https://github.com/' . $this->get( User::GITHUB );
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
	 * Aristocratic title column
	 */
	const ARISTOCRATIC_TITLE = 'user_title';

	/**
	 * ID column
	 */
	const SURNAME = 'user_surname';

	/**
	 * He/she public column
	 */
	const IS_PUBLIC = 'user_public';

	/**
	 * Image column
	 */
	const IMAGE = 'user_image';

	/**
	 * RSS column
	 */
	const RSS = 'user_rss';

	/**
	 * Facebook username column
	 */
	const FACEBOOK = 'user_fb';

	/**
	 * Linkedin username column
	 */
	const LINKEDIN = 'user_lnkd';

	/**
	 * Google+ username column
	 */
	const GOOGLE_PLUS = 'user_googl';

	/**
	 * Twitter username
	 */
	const TWITTER = 'user_twtr';

	/**
	 * GitHub username
	 */
	const GITHUB = 'user_github';

	/**
	 * Personal website column
	 */
	const WEBSITE = 'user_site';

	/**
	 * Loved license column
	 */
	const LOVED_LICENSE = 'user_lovelicense';

	/**
	 * Biography column
	 */
	const BIO = 'user_bio';

	/**
	 * Complete ID column name
	 */
	const ID_ = self::T . DOT . self::ID;

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
	 * Get all the user social fields
	 *
	 * @return array
	 */
	public static function allSocialFields() {
		return [
			User::RSS,
			User::FACEBOOK,
			User::LINKEDIN,
			User::GOOGLE_PLUS,
			User::TWITTER,
			User::GITHUB,
		];
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
