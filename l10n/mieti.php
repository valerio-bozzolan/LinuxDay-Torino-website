#!/usr/bin/php
<?php
# Linux Day 2016 - GNU Gettext feeder generating fake source code content from the database
# Copyright (C) 2016, 2018 Linux Day Torino
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
# ./mieti.php > trebbia.php

require __DIR__ . '/../load.php';

empty( $argv )
	and error_die("THIS FILE CAN SPAWN PHP CODE?!? RUN AWAY (╯°□°)╯");

$date = date( 'c' );

// header to be put in trebbia.php
echo <<< EOF
<?php
# Linux Day 2016 - Fake source code generated from the database to feed GNU Gettext
# Copyright (C) 2016, 2018 Linux Day Torino
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
// end header

spawn_gnu( Conference::T, [
	Conference::TITLE,
	Conference::DESCRIPTION,
], Conference::UID );

spawn_gnu( Event::T, [
	Event::TITLE,
	Event::SUBTITLE,
	Event::ABSTRACT,
	Event::DESCRIPTION,
], Event::UID );

spawn_gnu( Location::T, [
	Location::NAME,
	Location::ADDRESS,
	Location::NOTE,
] );

spawn_gnu( Track::T, [
	Track::NAME,
	Track::LABEL,
], Track::UID );

spawn_gnu( Chapter::T, [ Chapter::NAME  ], Chapter::UID );
spawn_gnu( Room   ::T, [ Room   ::NAME  ], Room   ::UID );
spawn_gnu( Skill  ::T, [ Skill  ::TITLE ], Skill  ::UID );

// footer to be put in trebbia.php
echo <<< EOF


######################################
##### Th-th-th-that's all folks! #####
######################################
EOF;
// end footer

function spawn_gnu( $from, $fields, $identifier = null ) {
	if( ! $identifier ) {
		$identifier = "{$from}_ID";
	}

	// Stripping evil carriage returns from the database
	$cols = [];
	foreach( $fields as $field ) {
		$cols[] = new DBCol( $field, sprintf(
			'REPLACE(`%1$s`, \'\r\n\', \'\n\')',
			$field
		), '-' );
	}
	query_update( $from, $cols, '1' /* WHERE 1 */ );

	$results = Query::factory()
		->select( $fields )
		->select( $identifier )
		->from( $from )
		->queryGenerator();

	foreach( $results as $result ) {
		$uid = $result->get( $identifier );
		spawn_linux( $from, $uid, $result, $fields );
	}
}

function spawn_linux( $from, $uid, $obj, $properties ) {
	foreach( $properties as $property ) {
		$value = $obj->get( $property );

		if( empty( $value ) ) {
			continue;
		}

		echo "\n\n";
		printf(
			"// %s[%s]::%s\n",
			$from,
			$uid,
			$property
		);

		$value = addcslashes( $value, '"\\' );

		printf( '__("%s");', $value );
	}
}
