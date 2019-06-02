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
 * This is the header of the website
 */

/*
 * Args that should be passed:
 *
 * $conference (object) Current conference
 */

// do not visit directly
defined( 'ABSPATH' ) or exit;

?>
<!DOCTYPE html>
<html lang="<?php echo latest_language()->getISO() ?>">
<head>
<!--
New Event
http://www.templatemo.com/tm-486-new-event
-->
<title>Linux Day Torino 2019</title>
<meta name="description" content="">
<meta name="author" content="<?php _e( "Comitato Linux Day Torino" ) ?>">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/owl.theme.css">
<link rel="stylesheet" href="css/owl.carousel.css">

<!-- Main css -->
<link rel="stylesheet" href="css/style.css">

<!-- Organic fonts grown locally, hand-picked for your enojyment. Guaranteed tracking-free, absolutely no CDNs! -->
<!-- Do you want even faster loading times with sites that use CDNs? Try https://decentraleyes.org/ (not sponsored, just a good extension) -->
<link href='/2019/css/poppins.css' rel='stylesheet' type='text/css'>

</head>
<body data-spy="scroll" data-offset="50" data-target=".navbar-collapse">


<!-- =========================
     NAVIGATION LINKS
============================== -->
<div class="navbar navbar-fixed-top custom-navbar" role="navigation">
	<div class="container">

		<!-- navbar header -->
		<div class="navbar-header">
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon icon-bar"></span>
				<span class="icon icon-bar"></span>
				<span class="icon icon-bar"></span>
			</button>
			<a href="#" class="navbar-brand"><?php _esc_html( $conference->getConferenceTitle() ) ?></a>
		</div>

		<div class="collapse navbar-collapse">

			<ul class="nav navbar-nav navbar-right">
				<li><a href="#intro" class="smoothScroll">Intro</a></li>
				<li><a href="#overview" class="smoothScroll">Overview</a></li>
				<li><a href="#speakers" class="smoothScroll">Speakers</a></li>
				<li><a href="#program" class="smoothScroll">Programs</a></li>
				<li><a href="#register" class="smoothScroll">Register</a></li>
				<li><a href="#venue" class="smoothScroll">Venue</a></li>
				<li><a href="#sponsors" class="smoothScroll">Sponsors</a></li>
				<li><a href="#contact" class="smoothScroll">Contact</a></li>
			</ul>

		</div>

	</div>
</div>
