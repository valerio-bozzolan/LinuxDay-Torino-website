<?php
# Linux Day 2016 - GNU Gettext feeder generating fake source code content from the database
# Copyright (C) 2016 Linux Day Torino
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

# Usage:
# php ./mieti.php > trebbia.php

require '../../load.php';

empty( $argv )
	&& error_die("THIS FILE CAN SPAWN PHP CODE?!? RUN AWAY (╯°□°)╯");

$date = date('c');

echo <<< EOF
<?php
# Linux Day 2016 - Fake source code generated from the database to feed GNU Gettext
# Copyright (C) 2016 Linux Day Torino
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

# Last update: $date
EOF;

spawn_gnu('conference', [
		'conference_title',
		'conference_description'
	],
	'conference_uid'
);

spawn_gnu('event', [
		'event_title',
		'event_subtitle',
		'event_abstract',
		'event_description'
	],
	'event_uid'
);

spawn_gnu('location', [
	'location_name',
	'location_address',
	'location_note'
] );

spawn_gnu('room',  'room_name',   'room_uid');
spawn_gnu('skill', 'skill_title', 'skill_uid');
spawn_gnu('track', 'track_name',  'track_uid');
spawn_gnu('user',  'user_bio',    'user_uid');

echo <<< EOF


######################################
##### Th-th-th-that's all folks! #####
######################################
EOF;

function spawn_gnu($from, $fields, $identifier = null) {
	force_array($fields);

	if($identifier === null) {
		$identifier = "{$from}_ID";
	}
	$fields[] = $identifier;

	$q = new DynamicQuery();
	$elements = $q->useTable($from)->selectField($fields)->query();

	if( ! $elements ) {
		return;
	}

	// Skip identifier
	array_pop($fields);

	while( $row = $elements->fetch_array() ) {
		$uid = $row[$identifier];
		spawn_linux($from, $uid, $row, $fields);
	}
}

function spawn_linux($from, $uid, $obj, $properties) {
	foreach($properties as $property) {
		$value = $obj[$property];

		if( empty($value) ) {
			continue;
		}

		echo "\n\n";

		printf(
			"// %s[%s]::%s\n",
			$from,
			$uid,
			$property
		);

		$value = addcslashes($value, '"\\');
		$value = str_replace("\r", '', $value);

		printf('_("%s");', $value);
	}
}
