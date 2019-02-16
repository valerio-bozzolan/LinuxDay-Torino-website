#!/usr/bin/php
<?php
# Linux Day - JSON importer
# Copyright (C) 2018 Linux Day Torino, Valerio Bozzolan
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

##################################################################################
# This script was created in order to import the work of data recovery done      #
# by Ludovico Pavesi, who scraped the dead websites from Internet Archive of the #
# past Linux Day Torino editions, after the burnout of the server in the 2018,   #
# after, discovering that Bobbinocaro had not any backup. asd                    #
# The format of this JSON file should be included soon somewhere, but you can    #
# guess it.                                                                      #
#                                                                                #
# Tl;dr this script is completly unuseful to you. But hey, who knows.            #
# -- Valerio Bozzolan Thu Nov  8 12:55:04 CET 2018                               #
##################################################################################

require __DIR__ . '/../load.php';

// allowed only from command line interface
if( ! isset( $argv[ 0 ] ) ) {
	exit( 1 );
}

// require first argument
if( ! isset( $argv[ 1 ] ) ) {
	echo "Usage:\n  {$argv[0]} FILE.json\n";
	exit( 1 );
}

// parse
$events = json_decode( file_get_contents( $argv[ 1 ] ) );
if( ! $events ) {
	echo "Error:\n  The file {$argv[1]} should exist and be JSON encoded\n";
	exit( 1 );
}

query( 'START TRANSACTION' );

foreach( $events as & $row ) {
	$year     =  $row->year;
	$title    =  $row->title;
	$uid      =  generate_slug( $title );
	$abstract = @$row->longDescription;
	$desc     = @$row->description;
	$authors  = @$row->authors;
	$slides   = @$row->slides; // array of strings

	$conference = Conference::factoryFromUID( $year )
		->queryRow();

	if( $conference ) {
		$conference_ID = $conference->getConferenceID();
	} else {
		insert_row( Conference::T, [
			new DBCol( Conference::UID,     $year,                    's' ),
			new DBCol( Conference::TITLE,   "Linux Day Torino $year", 's' ),
			new DBCol( Conference::ACRONYM, "LDTO$year",              's' ),
		] );
		$conference_ID = last_inserted_ID();
	}


	// insert the event
	insert_row( Event::T, [
		new DBCol( Event::UID,         $uid,           's'     ),
		new DBCol( Event::TITLE,       $title,         's'     ),
		new DBCol( Event::ABSTRACT,    $abstract,      'snull' ),
		new DBCol( Event::DESCRIPTION, $desc,          'snull' ),
		new DBCol( Event::LANGUAGE,    'it',           's'     ),
		new DBCol( Conference::ID,     $conference_ID, 'd'     ),
	] );

	$event_ID = last_inserted_ID();

	echo "added event $event_ID $title\n";

	if( ! $authors ) {
		continue;
	}

	$i = 0;
	foreach( $authors as $author ) {
		$i++;

		$nick    = @$author->nick;
		$name    =  $author->name;
		$surname =  $author->surname;

		if( ! $nick ) {
			$nick = generate_slug( "$name $surname" );
		}

		// try by nick
		$user = User::factoryFromUID( $nick )
			->queryRow();

		// try with surname
		if( ! $user ) {
			$user = User::factory()
				->whereStr( User::SURNAME, $surname )
				->queryRow();
		}

		$user_ID      = $user->getUserID();
		$user_uid     = $user->getUserUID();
		$user_name    = $user->getUserFullName();

		echo "\tadded user $user_ID $user_uid $user_name\n";

		// relate the user to the event
		insert_row( EventUser::T, [
			new DBCol( User     ::ID,    $user_ID,  'd' ),
			new DBCol( Event    ::ID,    $event_ID, 'd' ),
			new DBCol( EventUser::ORDER, $i,        'd' ),
		] );
	}
}

query( 'COMMIT' );
