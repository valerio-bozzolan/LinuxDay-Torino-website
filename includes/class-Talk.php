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
		if( isset( $t->talk_ID ) ) {
			$t->talk_ID   = (int) $t->talk_ID;
		}
		if( isset( $t->talk_hour ) ) {
			$t->talk_hour = (int) $t->talk_hour;
		}
	}

	/**
	 * The human name of the talk type, can be called statically.
	 *
	 * @return string
	 */
	function getTalkType($t = null) {
		if( $t === null ) {
			isset( $this->talk_type )
				|| error_die("Missing talk type");

			return self::getTalkType( $this->talk_type );
		}

		if( $t === 'base' )
			$t = _("Base");

		if( $t === 'dev' )
			$t = _("Dev");

		if( $t === 'misc' )
			$t = _("Misc");

		return sprintf(
			_("Area %s"),
			$t
		);
	}

	/**
	 * The human talk hour, can be called statically.
	 *
	 * @return string
	 */
	function getTalkHour($h = null) {
		if( $h === null ) {
			isset( $this->talk_hour )
				|| error_die("Missing talk hour");

			return self::getTalkHour( $this->talk_hour );
		}

		return sprintf( _("%d° ora"), $h );
	}

	function getTalkUsers() {
		isset( $this->talk_ID )
			|| error_die("Missing talk_ID");

		return query_results(
			sprintf(
				"SELECT " .
					"user.user_uid, ".
					"user.user_name, ".
					"user.user_surname ".
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

	function getTalkTitle() {
		return $this->talk_title;
	}
}

class Talk {
	use TalkTrait;

	static $AREAS = ['base', 'dev', 'misc'];
	const HOURS = 4;

	function __construct() {
		self::prepareTalk( $this );
	}
}
