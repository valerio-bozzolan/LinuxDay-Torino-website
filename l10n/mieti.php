#!/usr/bin/php
<?php
# Linux Day 2016 - GNU Gettext feeder generating fake source code content from the database
# Copyright (C) 2016, 2018, 2019 Linux Day Torino contributors
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
# Copyright (C) 2016, 2017, 2018, 2019 Linux Day Torino contributors
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

generate_gnu_gettext_from_table(
	Conference::T,
	Conference::ID,
		// select all Conference(s) with i18n suppport
		( new QueryConference() )
			->whereConferenceHasI18nSupport(),
	[
		Conference::TITLE,
		Conference::DESCRIPTION,
	],
	Conference::UID
);

generate_gnu_gettext_from_table(
	Event::T,
	Event::ID,
	// select all Event(s) related to a conference that has i18n suppport
	( new QueryEvent() )
		->where(
			"EXISTS (" .
				( new QueryConference() )
					->whereConferenceHasI18nSupport()
					->equals( 'conference.conference_ID', 'event.conference_ID' )
					->getQuery()
			. ")"
		),
	[
		Event::TITLE,
		Event::SUBTITLE,
	],
	Event::UID
);

generate_gnu_gettext_from_table(
	Location::T,
	Location::ID,
	null,
	[
		Location::NAME,
		Location::ADDRESS,
		Location::NOTE,

	]
);

generate_gnu_gettext_from_table(
	Track::T,
	Track::ID,
	null,
	[
		Track::NAME,
		Track::LABEL,
	],
	Track::UID
);

generate_gnu_gettext_from_table( Chapter::T, Chapter::ID, null, [ Chapter::NAME  ], Chapter::UID );
generate_gnu_gettext_from_table( Room   ::T, Room   ::ID, null, [ Room   ::NAME  ], Room   ::UID );
generate_gnu_gettext_from_table( Skill  ::T, Skill  ::ID, null, [ Skill  ::TITLE ], Skill  ::UID );

// footer to be put in trebbia.php
echo <<< EOF


######################################
##### Th-th-th-that's all folks! #####
######################################
EOF;
// end footer

function generate_gnu_gettext_from_table( $table, $id, $query, $fields, $identifier = null ) {
	if( ! $identifier ) {
		$identifier = $id;
	}

	if( !$query ) {
		$query = new Query();
		$query->from( $table );
	}

	// Stripping evil carriage returns from the database
	$cols = [];
	foreach( $fields as $field ) {
		$cols[] = new DBCol( $field, sprintf(
			'REPLACE(`%1$s`, \'\r\n\', \'\n\')',
			$field
		), '-' );
	}

	// run clean text fields
	( clone $query )
		->where( 1 ) // just a condition
		->update( $cols );

	// select the rows
	$results = $query
		->select( $fields )
		->select( $identifier )
		->queryGenerator();

	// for each row do something
	foreach( $results as $result ) {
		$uid = $result->get( $identifier );
		generate_gnu_gettext_from_row( $table, $uid, $result, $fields );
	}
}

function generate_gnu_gettext_from_row( $from, $uid, $obj, $properties ) {
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
