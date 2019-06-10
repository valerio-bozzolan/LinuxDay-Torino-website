<?php
# Linux Day Torino - API to generate a strange iCal file format
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

// load the framework
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'load.php';

// die if missing Conference UIR
if( empty( $_GET['conference'] ) ) {
	http_response_code( 404 );
	die( "Missing 'conference' argument" );
}

$event      = null;
$conference = FullConference::factoryFromUID( $_GET['conference'] )
	->queryRow();

// die if missing Conference
if( !$conference ) {
	http_response_code( 404 );
	die( "Conference not found" );
}

// die if missing Event UID
if( isset( $_GET['event'] ) ) {
	$event = FullEvent::factoryFromConferenceAndEventUID( $conference, $_GET['event'] )
		->queryRow();

	if( !$event ) {
		http_response_code( 404 );
		die( "Event not found" );
	}
}

$event_url = null;
if( $event ) {
	$event_ID    = $event->getEventID();
	$event_title = $event->getEventTitle();
	$event_start = $event->getEventStart();
	$event_end   = $event->getEventEnd();
	$event_desc  = $event->getEventDescription();
	if( $event->hasEventPermalink() ) {
		$event_url = $event->getEventURL();
	}
} else {
	$event_ID    = $conference->getConferenceID();
	$event_title = $conference->getConferenceTitle();
	$event_url   = $conference->getConferenceURL();
	$event_start = $conference->getConferenceStart();
	$event_end   = $conference->getConferenceEnd();
	$event_desc  = $conference->getConferenceDescription();
}

$event_uid = $conference->getConferenceUID();
if( $event ) {
	$event_uid .= '-' . $event->getEventUID();
}

if( $event ) {
	$event_stable_guid = $conference->getConferenceUID() . '-' . $event_ID . '@linuxdaytorino.org';
} else {
	$event_stable_guid = $conference->getConferenceUID() . '@linuxdaytorino.org';
}

$event_location = null; // TODO: get this one (e.g. "Room A" or "Via Fasulla 123, Springfield")
$event_geo_lat = null;
$event_geo_lng = null;
if( $conference->locationHasGeo() ) {
	$event_geo_lat = $conference->getLocationGeoLat();
	$event_geo_lng = $conference->getLocationGeoLng();
}

if( empty( $_GET['debug'] ) ) {
	header( 'Content-Type: text/calendar' );
	header( sprintf( 'Content-Disposition: attachment; filename=%s.ics', $event_uid ) );
} else {
	header( 'Content-Type: text/plain' );
}

echo get_ical(
	$event_stable_guid,
	$event_title,
	$event_start,
	$event_end,
	$event_url,
	$event_desc,
	$event_location,
	$event_geo_lat,
	$event_geo_lng
);

/**
 * Get an event (or conference as a single event) in iCal format.
 *
 * @param string $id Unique ID for this event
 * @param string $title Event title
 * @param int $start Start time (UNIX timestamp)
 * @param int $end End time (UNIX timestamp)
 * @param string $url Event URL
 * @param string $description Longer description of the event
 * @param string $location Name of event location, e.g. "Room A"
 * @param float $geo_lat Latitude of the location
 * @param float $geo_lon Longitude of the location
 *
 * @return string the event in iCal format
 */
function get_ical( $id, $title, $start, $end, $url = null, $description = null, $location = null, $geo_lat = null, $geo_lng = null ) {
	$start = clone $start;
	$end   = clone $end;
	$now   = new DateTime();

	$utc = new DateTimeZone( 'UTC' );
	$start->setTimezone( $utc );
	$end  ->setTimezone( $utc );
	$now  ->setTimezone( $utc );

	$dtstart = $start->format( 'U\Z' );
	$dtend   = $end  ->format( 'U\Z' );
	$dtstamp = $now  ->format( 'U\Z' );

	$rn = "\r\n";
	$id    = htmlspecialchars( $id    );
	$title = htmlspecialchars( $title );
	if( !$description ) {
		$opt_description = '';
	} else {
		$description = str_replace( "\n", " ", $description );
		$description = strip_tags( $description );
		$description = htmlspecialchars( $description );
		$opt_description = "DESCRIPTION:$description";
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
	if( !$location ) {
		$opt_location = '';
	} else {
		$location = htmlspecialchars( $location );
		$opt_location = "LOCATION:$location";
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
$opt_location
$opt_geo
DTSTART:$dtstart
DTEND:$dtend
DTSTAMP:$dtstamp
END:VEVENT
END:VCALENDAR
EOD;

	return str_replace( "\n", "\r\n", $ics );
}
