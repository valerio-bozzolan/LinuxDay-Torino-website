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

// TODO: move the define somewhere else (per-year, not a global parameter for every site across all years)
define('DEFAULT_LANGUAGE_ISO', 'it');

// I assume that latest_language()->getISO() does not return different codes for the same language:
// e.g. it should return ONLY it_IT OR it, not "it_IT" some times and "it" some others
// this does not appear to be the case and it breaks everything completely.

// l is either given in the request or implicit
$l = $_GET['l'] ?? latest_language()->getISO();

// From the manual: "This function may not give correct results for relative URLs."
// Then build a full URL!
$parsed = parse_url("https://${_SERVER['HTTP_HOST']}${_SERVER['REQUEST_URI']}");
if(isset($parsed["query"])) {
	parse_str($parsed["query"], $query);
} else {
	$query = [];
}

if($l === DEFAULT_LANGUAGE_ISO) {
	// Remove the ugly l
	if(isset($_GET['l'])) {
		unset($query["l"]);
	}

	// are there any remaining query parameters?
	if(count($query) > 0) {
		$query = '?' . http_build_query($query);
	} else {
		$query = '';
	}

	// l was there: redirect to page without l (or remove this "if" to get a canonical URL without l)
	if(isset($_GET['l'])) {
		// TODO: change to 301 when we're sure
		header("Location: ${parsed['path']}$query", true, 302);
		exit(0);
	}
} else {
	// Other languages need the l for the canonical URL
	$query["l"] = $l;
	$query = '?' . http_build_query($query);
}
$canonical = "https://${_SERVER['HTTP_HOST']}${parsed['path']}$query";
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

<link rel="canonical" href="<?= $canonical ?>">

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
