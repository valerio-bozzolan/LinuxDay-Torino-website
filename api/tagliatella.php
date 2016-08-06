<?php
// In case something goes wrong...
http_response_code(500);

require 'config.php';
define('DB_DSN', 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME);

$db_timezone = new DateTimeZone(DB_TIMEZONE);
$output_timezone = new DateTimeZone(OUTPUT_TIMEZONE);

$dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$xml = new DOMDocument('1.0', 'UTF-8');
$schedule = $xml->createElement('schedule');
$schedule = $xml->appendChild($schedule);
$conference = $xml->createElement('conference');
$conference = $schedule->appendChild($conference);

$result = $dbh->query('SELECT title, subtitle, venue, city, `start`, `end`, days, day_change, timeslot_duration FROM conferences WHERE id='.CONFERENCE_ID);

if($result->rowCount() === 0) {
    throw new LogicException('Conference '.CONFERENCE_ID.' does not exist!');
} else {
    $result = $result->fetch();
    foreach($result as $tag => $content) {
        addChild($xml, $conference, $tag, $content);
    }
}

$events = $dbh->query('SELECT `events`.id, `events`.title, `events`.subtitle, `events`.slug, `events`.abstract, `events`.description, `events`.language,
rooms.name AS room,
event_types.name AS type,
tracks.name AS track,
`events`.`start`, `events`.`end`
FROM `events`
JOIN rooms ON events.room=rooms.id
JOIN tracks ON events.track=tracks.id
JOIN event_types ON events.type=event_types.id
WHERE `events`.conference_id='.CONFERENCE_ID.'
ORDER BY events.start, rooms.id');

$events_by_date_then_room = [];
foreach($events as $event) {
    // Convert "datetime" fields to PHP DateTime objects
    $event['start'] = new DateTime($event['start'], $db_timezone);
    $event['end'] = new DateTime($event['end'], $db_timezone);
    // Assume they are in DB_TIMEZONE time zone
    $event['start']->setTimezone($output_timezone);
    $event['start']->setTimezone($output_timezone);
    $event['duration'] = $event['start']->diff($event['end']);

    $day = $event['start']->format('Y-m-d');
    
    // Add various levels to the array, if they don't already exists
    if(!isset($events_by_date_then_room[$day])) {
        $events_by_date_then_room[$day] = [];
    }

    if(!isset($events_by_date_then_room[$day][$event['room']])) {
        $events_by_date_then_room[$day][$event['room']] = [];
    }

    // And finally, add the event itself
    $events_by_date_then_room[$day][$event['room']][] = $event;
}

// These are database fields, array keys and XML tags whose content can be taken straight from the database. Others need a little more work to convert to the correct format.
$keys = ['room', 'title', 'subtitle', 'track', 'type', 'language', 'abstract', 'description', 'slug'];
$day_index = 1;
//
$events_by_id = [];
foreach($events_by_date_then_room as $day_date => $rooms) {
    $dayxml = addChild($xml, $schedule, 'day', NULL);
    $dayxml->setAttribute('index', $day_index);
    $dayxml->setAttribute('date', $day_date);

    foreach($rooms as $room_name => $events) {
        $roomxml = addChild($xml, $dayxml, 'room', NULL);
        $roomxml->setAttribute('name', $room_name);

        foreach($events as $event) {
            $eventxml = addChild($xml, $roomxml, 'event', NULL);
            $eventxml->setAttribute('id', $event['id']);

            $events_by_id[$event['id']] = $eventxml;

            // this stops PHPStorm from complaining, but most of these elements are really just strings...
            /** @var $event DateTime[] */
            // Same exact format, two different parameters since 'start' is a DateTime and 'duration' a DateInterval. Why, PHP, WHY?
            addChild($xml, $eventxml, 'start', $event['start']->format('H:i'));
            addChild($xml, $eventxml, 'duration', $event['duration']->format('%H:%I'));
            // Add elements that don't need any further processing
            foreach($keys as $k) {
                addChild($xml, $eventxml, $k, $event[$k]);
            }

        }
    }

    $day_index++;
}

$lastid = NULL;
$lastpersons = NULL;
$select_people = $dbh->query('SELECT `events`.id AS `event`, people.name, people.id FROM people JOIN events_people ON people.id=events_people.person_id JOIN `events` ON `events`.id=events_people.event_id WHERE events.conference_id = '.CONFERENCE_ID.' ORDER BY `event`');
while($row = $select_people->fetch()) {
    // This works only because rows are sorted (ORDER BY `event`)
    if($lastid !== $row['event']) {
        $lastid = $row['event'];

        $personsxml = $xml->createElement('persons');
        $personsxml = $events_by_id[$row['event']]->appendChild($personsxml);
        $lastpersons = $personsxml;
    }

    $personxml = addChild($xml, $lastpersons, 'person', $row['name']);
    $personxml->setAttribute('id', $row['id']);
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
