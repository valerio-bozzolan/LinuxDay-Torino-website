<?php
# Linux Day 2016 - API to generate a strange XML file format
# Copyright (C) 2016 Ludovico Pavesi, Valerio Bozzolan
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

require '../../load.php';

require 'config.php';

// In case something goes wrong...
http_response_code(500);

if( empty( $_GET['conference_ID'] ) ) {
	throw new LogicException('Undefined GET conference_ID');
}

$xml = new DOMDocument('1.0', 'UTF-8');
$schedule   = $xml->createElement('schedule');
$schedule   = $xml->appendChild($schedule);
$conference = $xml->createElement('conference');
$conference = $schedule->appendChild($conference);

$conference_row = Conference::getConference(
	luser_input( $_GET['conference'], 32 )
);

if( ! $conference_row ) {
	throw new LogicException( sprintf(
		"Conference with ID '%s' does not exists!",
		esc_html( CONFERENCE_ID )
	) );
} else {
	$conference_fields = [
		'title',
		'subtitle',
		'venue',
		'city',
		'days',
		'day_change',
		'timeslot_duration'
	];

	foreach($conference_fields as $field) {
		addChild($xml, $conference, $field, $conference_row->{"conference_$field"});
	}

	addChild($xml, $conference, 'start', $conference_row->getConferenceStart('Y-m-d H:i:s') );
	addChild($xml, $conference, 'end',   $conference_row->getConferenceEnd('Y-m-d H:i:s') );
}

$events = query_results(
	sprintf(
		'SELECT '.
			'event_ID, '.
			'event_uid, '.
			'event_title, '.
			'event_subtitle, '.
			'event_abstract, '.
			'event_description, '.
			'event_language, '.
			'event_start, '.
			'event_end, '.
			'room.room_ID, '.
			'room_name, '.
			'chapter_name, '.
			'track.track_ID, '.
			'track_name, '.
			'chapter.chapter_ID, '.
			'chapter_name '.
			"FROM {$JOIN('event', 'room', 'track', 'chapter')} ".
		'WHERE '.
			'event.room_ID = room.room_ID AND '.
			'event.track_ID = track.track_ID AND '.
			'event.chapter_ID = chapter.chapter_ID AND '.
			'conference_ID = %d '.
		'ORDER BY '.
			'event_start, '.
			'room.room_ID'

		,
		CONFERENCE_ID
	),
	'Event'
);

// Room names indexed by room_ID
$room_names = [];

$events_by_date_then_room = [];
foreach($events as $event) {
	// Here event_start, event_end are PHP DateTime objects

	$event->event_duration = $event->event_start->diff( $event->event_end );

	$day = $event->event_start->format('Y-m-d');

	// Add various levels to the array, if they don't already exists
	if( ! isset($events_by_date_then_room[$day] ) ) {
		$events_by_date_then_room[$day] = [];
	}

	$room = $event->room_ID;

	if( ! isset($events_by_date_then_room[$day][$room] ) ) {
		$events_by_date_then_room[$day][$room] = [];
	}

	$room_names[ $room ] = $event->room_name;

	// And finally, add the event itself
	$events_by_date_then_room[$day][$room][] = $event;
}

// These are database event fields whose content can be taken straight from the database.
// Others need a little more work to convert to the correct format.
$keys = [
	'title',
	'subtitle',
	'language',
	'abstract',
	'description'
];

$day_index = 1;
$events_by_id = [];
foreach($events_by_date_then_room as $day_date => $rooms) {
	$dayxml = addChild($xml, $schedule, 'day', NULL);
	$dayxml->setAttribute('index', $day_index);
	$dayxml->setAttribute('date', $day_date);

	foreach($rooms as $room_ID => $events) {
		$roomxml = addChild($xml, $dayxml, 'room', NULL);

		// 9 agosto 2016 22:30 Ludovico says that this does not exist. OK.
		// 9 agosto 2016 22:31 Ludovico says that this exists. OK.
		$roomxml->setAttribute('name', $room_names[ $room_ID ] );

		foreach($events as $event) {
			$event_ID = $event->event_ID;

			$eventxml = addChild($xml, $roomxml, 'event', NULL);
			$eventxml->setAttribute('id', $event_ID);

			$events_by_id[$event_ID] = $eventxml;

			// this stops PHPStorm from complaining, but most of these elements are really just strings...
			/** @var $event DateTime[] */
			// Same exact format, two different parameters since 'start' is a DateTime and 'duration' a DateInterval. Why, PHP, WHY?
			addChild($xml, $eventxml, 'slug',    $event->event_uid );
			addChild($xml, $eventxml, 'start',    $event->event_start->format('H:i') );
			addChild($xml, $eventxml, 'duration', $event->event_duration->format('%H:%I') );
			addChild($xml, $eventxml, 'room',     $event->room_name );
			addChild($xml, $eventxml, 'track',    $event->track_name );
			addChild($xml, $eventxml, 'type',     $event->chapter_name );

			// Add event fields that don't need any further processing
			foreach($keys as $k) {
				addChild($xml, $eventxml, $k, $event->{"event_$k"});
			}

		}
	}

	$day_index++;
}

$lastid = NULL;
$lastpersons = NULL;
$select_people = query(
	sprintf(
		'SELECT '.
			'event.event_ID, '.
			'user.user_ID, '.
			'user.user_uid, '.
			'user_name, '.
			'user_surname '.
			 "FROM {$JOIN('event', 'event_user', 'user')} ".
		'WHERE '.
			'event.conference_ID = %d AND '.
			'event.event_ID = event_user.event_ID AND '.
			'user.user_ID = event_user.user_ID '.
		'ORDER BY '.
			'event_ID'

		,
		CONFERENCE_ID
	)
);

while( $row = $select_people->fetch_object('User') ) {
	// This works only because rows are sorted (ORDER BY `event`)
	if($lastid !== $row->event_ID) {
		$event  = $row->event_ID;
		$lastid = $event;

		$personsxml  = $xml->createElement('persons');
		$personsxml  = $events_by_id[$event]->appendChild($personsxml);
		$lastpersons = $personsxml;
	}

	$personxml = addChild($xml, $lastpersons, 'person', $row->getUserFullname() );
	$personxml->setAttribute('id', $row->user_ID);
	$personxml->setAttribute('slug', $row->user_uid);
}

if(OUTPUT_FILE !== NULL) {
	// Try to save, if it fails throw an exception
	if($xml->save(OUTPUT_FILE) === false) {
		throw new RuntimeException('Failed to write '.OUTPUT_FILE);
	}
}

// If we got here, no exception has been raised. Probably.
if(OUTPUT_RESPONSE) {
	http_response_code(200);
	header('Content-type: text/xml; charset=utf-8');
	echo $xml->saveXML();
} else {
	http_response_code(204);
}
exit();

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
function addChild($xml, $parent, $tagname, $content) {
	$child = $xml->createElement($tagname);
	if($content !== NULL && $content !== '') {
		$child->textContent = $content;
	}
	return $parent->appendChild($child);
}
