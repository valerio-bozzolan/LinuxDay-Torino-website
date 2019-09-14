<?php
# Linux Day Torino website
# Copyright (C) 2016, 2017, 2018, 2019 Ludovico Pavesi, Valerio Bozzolan and contributors
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.

/**
 * Rappresent an User Social Box
 */
class UserSocialBox {

	/**
	 * Spawn a social box
	 *
	 * @param string  $user User
	 * @param string  $social string Social title
	 * @param string  $profile string Profile URL
	 * @param string  $path string Icon path
	 * @param boolean $is_icon
	 */
	public static function spawn( $user, $social, $profile, $path, $is_icon = false ) {

		// call the related template
		template( 'user-social-box', [
			'user'    => $user,
			'social'  => $social,
			'profile' => $profile,
			'path'    => $path,
			'is_icon' => $is_icon,
		] );
	}

}
