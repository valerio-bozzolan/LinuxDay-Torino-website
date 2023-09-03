<?php
# Linux Day Torino Website
# Copyright (C) 2016-2023 Valerio Bozzolan, Linux Day Torino website contributors
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
 * This file is the navigation bar of the website.
 */

// Do not allow to visit this file directly to avoid confusing things.
if( !defined( 'ABSPATH' ) ) {
	exit;
}

?>

	<!-- Menu -->
	<nav id="menu">
		<h2><?= __( "Menu" ) ?></h2>
		<ul>
			<li><a href="<?= CURRENT_CONFERENCE_PATH ?>/"><?= __( "Home" ) ?></a></li>
			<li><a href="<?= CURRENT_CONFERENCE_PATH ?>/intro/"><?= __( "Intro" ) ?></a></li>
			<li><a href="<?= CURRENT_CONFERENCE_PATH ?>/location/"><?= __( "Location" ) ?></a></li>
			<li><a href="<?= CURRENT_CONFERENCE_PATH ?>/program/"><?= __( "Programma" ) ?></a></li>
			<li><a href="<?= CURRENT_CONFERENCE_PATH ?>/contact/"><?= __( "Contatti" ) ?></a></li>
		</ul>
	</nav>

