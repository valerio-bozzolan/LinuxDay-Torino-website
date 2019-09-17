<?php
# Linux Day Torino website
# Copyright (C) 2016, 2017, 2018 2019 Ludovico Pavesi, Valerio Bozzolan and contributors
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

/*
 * This is the template for an user social box
 */

/*
 * Args that should be passed:
 *
 * $user User
 * $social string Social title
 * $profile string Profile URL
 * $path string Icon path
 * $is_icon
 */

// do not visit directly
defined( 'ABSPATH' ) or exit;
?>

	<div class="col-sm-4 col-md-3 col-lg-2">
		<?php
			$title = sprintf(
				__("%s su %s"),
				$user->getUserFullname(),
				$social
			);

			$logo = $is_icon
				? icon( $path )
				: HTML::img( ROOT . "/2016/static/social/$path", $social, $title, 'responsive-img' );

			echo HTML::a( $profile, $logo, $title, null, 'target="_blank" rel="noreferrer nofollow"' );
		?>
	</div>
