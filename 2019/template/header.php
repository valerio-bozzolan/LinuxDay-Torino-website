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
 * $conference (object)         Current conference
 * $intro      (true|undefined) If true, you want that damn splash screen
 */

// do not visit directly
defined( 'ABSPATH' ) or exit;

// as default declare empty OG Meta tags
if( ! isset( $args['og'] ) ) {
	$args['og'] = [];
}

// set default OG Meta tags
$args['og'] = array_replace( [
	'image'  => CURRENT_CONFERENCE_URL . '/images/linux-day-2019.png', // It's better an absolute URL here
	'type'   => 'website',
	'title'  => $conference->getConferenceTitle(),
], $args['og'] );

?>
<!DOCTYPE html>
<html lang="<?= latest_language()->getISO() ?>">
<head>
<!--
New Event
http://www.templatemo.com/tm-486-new-event
-->
<title><?= esc_html( $conference->getConferenceTitle() ) ?></title>
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

<?php foreach( $args['og'] as $id => $value ): ?>
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
