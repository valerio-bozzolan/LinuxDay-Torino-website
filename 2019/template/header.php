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
 * $title      (string)         Page title
 * $conference (object)         Current conference
 * $intro      (true|undefined) If true, you want that damn splash screen
 * $og         (array)          OG meta tags
 * $canonical  (string)         Canonical link tag
 */

// do not visit directly
defined( 'ABSPATH' ) or exit;

// site name
$sitename = $conference->getConferenceTitle();

// page title (if any)
$title = isset( $title ) ? $title : null;

// page title
$title_dashed = $sitename;
if( isset( $title ) ) {
	$title_dashed = sprintf(
		__( "%s - %s" ),
		$title,
		$sitename
	);
}

// canonical URL
$canonical = isset( $canonical ) ? $canonical : null;

// if the canonical is specified, and we have to force the permalink, force that damn permalink
if( $canonical && FORCE_PERMALINK ) {
	force_permalink( $canonical );
}

// as default declare empty OG Meta tags
if( ! isset( $og ) ) {
	$og = [];
}

// set default OG Meta tags
$og = array_replace( [
	'url'    => $canonical,
	'image'  => CURRENT_CONFERENCE_URL . '/images/linux-day-2019.png', // It's better an absolute URL here
	'type'   => 'website',
	'title'  => $title,
], $og );
?>
<!DOCTYPE html>
<html lang="<?= latest_language()->getISO() ?>">
<head>
<!--
New Event
http://www.templatemo.com/tm-486-new-event
-->
<title><?= esc_html( $title_dashed ) ?></title>
<meta name="author" content="<?= esc_attr( __( "Comitato Linux Day Torino" ) ) ?>">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<link rel="stylesheet" href="<?= CURRENT_CONFERENCE_ROOT ?>/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= CURRENT_CONFERENCE_ROOT ?>/css/font-awesome.min.css">
<link rel="stylesheet" href="<?= CURRENT_CONFERENCE_ROOT ?>/css/owl.theme.css">
<link rel="stylesheet" href="<?= CURRENT_CONFERENCE_ROOT ?>/css/owl.carousel.css">

<!-- Main css -->
<link rel="stylesheet" href="<?= CURRENT_CONFERENCE_ROOT ?>/css/style.css">

<!-- Organic fonts grown locally, hand-picked for your enojyment. Guaranteed tracking-free, absolutely no CDNs! -->
<!-- Do you want even faster loading times with sites that use CDNs? Try https://decentraleyes.org/ (not sponsored, just a good extension) -->
<link href='<?= CURRENT_CONFERENCE_ROOT ?>/css/poppins.css' rel='stylesheet' type='text/css'>

<?php if( $canonical ): ?>
	<link rel="canonical" href="<?= esc_attr( $canonical ) ?>" />
<?php endif ?>

<?php foreach( $og as $id => $value ): ?>
	<meta property="og:<?= esc_attr( $id ) ?>" content="<?= esc_attr( $value ) ?>" />
<?php endforeach ?>

<?php load_module('header') ?>

</head>
<body data-spy="scroll" data-offset="50" data-target=".navbar-collapse">

<?php
template( 'easter-egg' );

template( 'navbar-home', [
	'conference'       => $conference,
	'top_nav_collapse' => !isset( $intro ),
] );

if( isset( $intro ) ) {
	template( 'intro' );
}
