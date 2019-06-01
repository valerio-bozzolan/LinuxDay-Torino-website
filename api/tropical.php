<?php
# Linux Day 2016 - API to generate a strange XML file format
# Copyright (C) 2019 Ludovico Pavesi, Valerio Bozzolan
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

/*
 * This is the Linux Day Torino Tropical (trop-iCal) API
 *
 * It print a (hopefully) valid iCal file of a Linux Day Torino event.
 */

/*
 * This is the Linux Day Torino Tropical (trop-iCal) API
 *
 * It print a (hopefully) valid iCal file of a Linux Day Torino event.
 */

// load the framework
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'load.php';

// conference UID e.g. '2019'
$conference_uid = isset( $_GET['conference'] )
                       ? $_GET['conference']
                       : CURRENT_CONFERENCE_UID;

$event      = null;
$conference = FullConference::factoryFromUID( $conference_uid )
	->queryRow();

// die if missing Conference
if( !$conference ) {
	http_response_code( 404 );
	die( "Cannot find conference" );
}

// die if missing Event parameter
if( empty( $_GET['event'] ) ) {
	http_response_code( 400 );
	die( "If you specify the 'conference' (string) you must specify 'event' (str)" );
}

$event = FullEvent::factoryFromConferenceAndEventUID( $conference, $_GET['event'] )
	->queryRow();

$event_url     = null;
$event_geo_lat = null;
$event_geo_lng = null;
if( $event->hasEventPermalink() ) {
	$event_url = $event->getEventURL();
}

if( $conference->locationHasGeo() ) {
	$event_geo_lat = $conference->getLocationGeoLat();
	$event_geo_lng = $conference->getLocationGeoLng();
}

if( !$event ) {
	http_response_code( 404 );
	die( "Cannot find event" );
}

if( empty( $_GET['debug'] ) ) {
	header( 'Content-Type: text/calendar' );
}

echo get_ical(
	$event->getEventID(),
	$event->getEventTitle(),
	$event->getEventStart( 'U' ),
	$event->getEventEnd(   'U' ),
	$event_url,
	$event->getEventDescription(),
	$event_geo_lat,
	$event_geo_lng
);

function get_ical( $id, $title, $start, $end, $url = null, $description = null, $geo_lat = null, $geo_lng = null ) {
    $rn = "\r\n";
    $dtstart = date( 'Ymd\Tgis\Z', $start );
    $dtend   = date( 'Ymd\Tgis\Z', $end   );
    $dtstamp = date( 'Ymd\Tgis\Z', time() );
    $title = htmlspecialchars( $title );
    if( !$description ) {
        $opt_description = '';
    } else {
    	$description = str_replace( "\n", " ", $description );
        $opt_description = 'DESCRIPTION:' . htmlspecialchars( strip_tags( $description ) );
    }
    if( !$url ) {
        $opt_url = '';
    } else {
        $opt_url = 'URL;VALUE=URI:' . htmlspecialchars( $url );
    }
    if( !$geo_lat || !$geo_lng ) {
        $opt_geo = '';
    } else {
        $opt_geo = "GEO:$geo_lat;$geo_lng";
    }

    $ics = <<<EOD
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//ldto/asd//NONSGML v1.0//EN
CALSCALE:GREGORIAN
BEGIN:VEVENT
UID:$id
SUMMARY:$title
$opt_description
$opt_url
$opt_geo
DTSTART:$dtstart
DTEND:$dtend
DTSTAMP:$dtstamp
END:VEVENT
END:VCALENDAR
EOD;

	return str_replace( "\n", "\r\n", $ics );
}
