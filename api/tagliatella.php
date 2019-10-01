<?php
# Linux Day 2016 - API to generate a strange XML file format
# Copyright (C) 2016, 2018 Ludovico Pavesi, Valerio Bozzolan
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

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'load.php';

// In case something goes wrong...
http_response_code( 500 );

$uid = isset( $_GET[ 'conference' ] )
	? $_GET[ 'conference' ]
	: CURRENT_CONFERENCE_UID;

$conference_row = FullConference::factoryFromUID( $uid )
	->queryRow();

if( ! $conference_row ) {
	throw new LogicException( sprintf(
		"Conference with uid '%s' does not exists!",
		esc_html( $uid )
	) );
}

$xml = new DOMDocument( '1.0', 'UTF-8' );
$schedule   = $xml->createElement( 'schedule' );
$schedule   = $xml->appendChild( $schedule );
$conference = $xml->createElement( 'conference' );
$conference = $schedule->appendChild( $conference );

$conference_fields = [
	'title'       => $conference_row->getConferenceTitle(),
	'subtitle'    => $conference_row->getConferenceSubtitle(),
	'acronym'     => $conference_row->get( Conference::ACRONYM ),
	'days'        => $conference_row->get( Conference::DAYS ),
	'persons_url' => $conference_row->get( Conference::PERSONS_URL ),
	'events_url'  => $conference_row->get( Conference::EVENTS_URL ),
];

foreach( $conference_fields as $xml_field => $db_field ) {
	add_child( $xml, $conference, $xml_field, $db_field );
}

add_child( $xml, $conference, 'start', $conference_row->getConferenceStart( 'Y-m-d H:i:s' ) );
add_child( $xml, $conference, 'end',   $conference_row->getConferenceEnd( 'Y-m-d H:i:s' ) );
add_child( $xml, $conference, 'city',  $conference_row->getLocationAddress() );
add_child( $xml, $conference, 'venue', $conference_row->getLocationNoteHTML() );

// Yes, these are hardcoded. asd
add_child( $xml, $conference, 'day_change',        '09:00:00' );
add_child( $xml, $conference, 'timeslot_duration', '00:30:00' );

$events = FullEvent::factoryByConference( $conference_row->getConferenceID() )
	->orderBy( Event::START )
	->orderBy( Room::ID_ )
	->queryGenerator();

// Room names indexed by room_ID
$room_names = [];

$events_by_date_then_room = [];
foreach( $events as $event ) {

	$day = $event->getEventStart( 'Y-m-d' );

	// Add various levels to the array, if they don't already exists
	if( ! isset( $events_by_date_then_room[ $day ] ) ) {
		$events_by_date_then_room[ $day ] = [];
	}

	$room = $event->getRoomID();

	if( ! isset( $events_by_date_then_room[ $day ][ $room ] ) ) {
		$events_by_date_then_room[ $day ][ $room ] = [];
	}

	$room_names[ $room ] = $event->getRoomName();

	// And finally, add the event itself
	$events_by_date_then_room[ $day ][$room ][] = $event;
}

// These are database event fields whose content can be taken straight from the database.
// Others need a little more work to convert to the correct format.
$keys = [
	'subtitle' => Event::SUBTITLE,
	'language' => Event::LANGUAGE,
];

$day_index = 1;
$events_by_id = [];
foreach( $events_by_date_then_room as $day_date => $rooms ) {
	$dayxml = add_child( $xml, $schedule, 'day', NULL );
	$dayxml->setAttribute( 'index', $day_index );
	$dayxml->setAttribute( 'date', $day_date );

	foreach( $rooms as $room_ID => $events ) {
		$roomxml = add_child( $xml, $dayxml, 'room', NULL );

		// 9 agosto 2016 22:30 Ludovico says that this does not exist. OK.
		// 9 agosto 2016 22:31 Ludovico says that this exists. OK.
		$roomxml->setAttribute( 'name', $room_names[ $room_ID ] );

		foreach( $events as $event ) {
			$event_ID = $event->getEventID();

			$eventxml = add_child( $xml, $roomxml, 'event', NULL );
			$eventxml->setAttribute( 'id', $event_ID );

			$events_by_id[ $event_ID ] = $eventxml;

			// this stops PHPStorm from complaining, but most of these elements are really just strings...
			/** @var $event DateTime[] */
			// Same exact format, two different parameters since 'start' is a DateTime and 'duration' a DateInterval. Why, PHP, WHY?
			add_child( $xml, $eventxml, 'title',    $event->getEventTitle() );
			add_child( $xml, $eventxml, 'slug',     $event->getEventUID() );
			add_child( $xml, $eventxml, 'start',    $event->getEventStart( 'H:i' ) );
			add_child( $xml, $eventxml, 'duration', $event->getEventDuration( '%H:%I' ) );
			add_child( $xml, $eventxml, 'room',     $event->getRoomName() );
			add_child( $xml, $eventxml, 'track',    $event->getTrackName() );
			add_child( $xml, $eventxml, 'type',     $event->getChapterName() );

			$description = null;
			if( $event->hasEventDescription() ) {
				$description = $event->getEventDescriptionHTML();
			}
			add_child( $xml, $eventxml, 'description', $description );

			$abstract = null;
			if( $event->hasEventAbstract() ) {
				$abstract = $event->getEventAbstractHTML();
			}
			add_child( $xml, $eventxml, 'abstract', $abstract );

			// Add event fields that don't need any further processing
			foreach( $keys as $xml_key => $db_key ) {
				add_child( $xml, $eventxml, $xml_key, $event->get( $db_key ) );
			}
		}
	}

	$day_index++;
}

$people = EventUser::factory()
	->select( [
		Event::ID_,
		User::ID_,
		User::UID,
		User::NAME,
		User::SURNAME
	] )
	->from( [
		Event::T,
		User::T,
	] )
	->whereInt( Conference::ID , $conference_row->getConferenceID() )
	->equals( EventUser::EVENT_, Event::ID_ )
	->equals( EventUser::USER_,  User ::ID_ )
	->orderBy( Event::ID )
	->queryGenerator();

$lastid = NULL;
$lastpersons = NULL;
foreach( $people as $row ) {
	// This works only because rows are sorted by events
	$event_ID = $row->getEventID();

	if( $lastid !== $event_ID ) {
		$event  = $event_ID;
		$lastid = $event;

		$personsxml  = $xml->createElement( 'persons' );
		$personsxml  = $events_by_id[ $event ]->appendChild( $personsxml );
		$lastpersons = $personsxml;
	}

	$personxml = add_child( $xml, $lastpersons, 'person', $row->getUserFullname() );
	$personxml->setAttribute( 'id',   $row->getUserID()  );
	$personxml->setAttribute( 'slug', $row->getUserUID() );
}

http_response_code( 200 );
header( 'Content-type: text/xml; charset=' . CHARSET );
echo $xml->saveXML();

// ----------------------------------------------------------------------------

/**
 * Add child to an element and return it
 *
 * @param $xml DOMDocument
 * @param $parent DOMNode
 * @param $tagname string
 * @param $content string
 * @return DOMElement
 */
function add_child( & $xml, $parent, $tagname, $content ) {
	$child = $xml->createElement( $tagname );
	if( null !== $content && '' !== $content ) {
		$child->nodeValue = $content;
	}
	return $parent->appendChild( $child );
}
