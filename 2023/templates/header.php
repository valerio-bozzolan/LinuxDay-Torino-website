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
 * This file is the header of the website.
 */

// Do not allow to visit this file directly to avoid confusing things.
if( !defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?= SITE_NAME ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="<?= CURRENT_CONFERENCE_PATH ?>/assets/css/main.css" />
		<noscript><link rel="stylesheet" href="<?= CURRENT_CONFERENCE_PATH ?>/assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
		<div id="wrapper">

			<!-- Header -->
			<header id="header">
				<div class="inner">

					<!-- Logo -->
					<a href="<?= CURRENT_CONFERENCE_PATH ?>/" class="logo">
						<span class="symbol"><img src="<?= CURRENT_CONFERENCE_PATH ?>/images/logo.svg" alt="" /></span><span class="title"><?= SITE_NAME ?></span>
					</a>
				</div>

				<!-- Nav -->
				<nav>
					<ul>
						<li><a href="#menu"><?= __( "Menu" ) ?></a></li>
					</ul>
				</nav>
			</header>

			<?php template( 'navigation' ) ?>

			<!-- Main -->
			<div id="main">
