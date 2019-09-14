<?php
# Linux Day Torino website
# Copyright (C) 2019 Ludovico Pavesi, Valerio Bozzolan and contributors
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
 * This is the navbar of the website
 */

/*
 * Args that should be passed:
 *
 * $conference (object) Current conference
 */

// do not visit directly
defined( 'ABSPATH' ) or exit;

?>
<!-- =========================
     NAVIGATION LINKS
============================== -->
<div class="navbar navbar-fixed-top custom-navbar" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon icon-bar"></span>
				<span class="icon icon-bar"></span>
				<span class="icon icon-bar"></span>
			</button>
			<a href="#" class="navbar-brand"><?= esc_html( $conference->getConferenceTitle() ) ?></a>
		</div>

		<div class="collapse navbar-collapse">

			<ul class="nav navbar-nav navbar-right">
				<li><a href="#intro" class="smoothScroll">Intro</a></li>
				<li><a href="#overview" class="smoothScroll">Overview</a></li>
				<li><a href="#program" class="smoothScroll">Programs</a></li>
				<li><a href="#venue" class="smoothScroll">Venue</a></li>
				<li><a href="#sponsors" class="smoothScroll">Sponsors</a></li>
				<li><a href="#contact" class="smoothScroll">Contact</a></li>
			</ul>

		</div>
	</div>
</div>
