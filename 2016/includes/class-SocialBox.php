<?php
# Linux Day 2016 - Social box
# Copyright (C) 2016, 2017, 2018 Valerio Bozzolan, Ludovico Pavesi, Linux Day Torino
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

/**
 * Social box
 */
class SocialBox {

	/**
	 * Spawn a social box
	 *
	 * @param $user User
	 * @param $social string Social title
	 * @param $profile string Profile URL
	 * @param $path string Icon path
	 * @param $is_icon
	 */
	public static function spawn( $user, $social, $profile, $path, $is_icon = false ) { ?>
		<div class="col s4 m3 l2">
			<?php
			$title = sprintf(
				__("%s su %s"),
				$user->getUserFullname(),
				$social
			);

			$logo = $is_icon
				? icon( $path )
				: HTML::img( STATIC_PATH . "/social/$path", $social, $title, 'responsive-img' );

			echo HTML::a( $profile, $logo, $title, null, 'target="_blank" rel="noreferrer nofollow"' ); ?>
		</div><?php
	}

}
