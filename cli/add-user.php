#!/usr/bin/php
<?php
# Linux Day - command line interface to create an user
# Copyright (C) 2018, 2019 Valerio Bozzolan
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

// allowed only from command line interface
if( ! isset( $argv[ 0 ] ) ) {
	exit( 1 );
}

// autoload the framework
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'load.php';

// command line arguments
$opts = getopt( 'h', [
	'uid:',
	'role:',
	'pwd:',
	'force::',
	'help',
] );

// show help
if( ! isset( $opts[ 'uid' ], $opts[ 'pwd' ], $opts[ 'role' ] ) || isset( $opts[ 'help' ] ) || isset( $opts[ 'h' ] ) ) {
	printf( "Usage: %s [OPTIONS]\n", $argv[ 0 ] );
	echo "OPTIONS:\n";
	echo "    --uid=UID          user UID\n";
	echo "    --role=ROLE        user role (user|admin|translator)\n";
	echo "    --pwd=PASSWORD     password\n";
	echo "    --force            update the user password if exists\n";
	echo " -h --help             show this help and exit\n";
	exit( 0 );
}

// look for existing user
$user = User::factoryFromUID( $opts[ 'uid' ] )
	->select( User::ID )
	->queryRow();

if( $user && ! isset( $opts[ 'force' ] ) ) {
	printf( "User %s already exist\n", $opts[ 'uid' ] );
	exit( 1 );
}

$pwd = User::encryptPassword( $opts[ 'pwd' ] );

if( $user ) {
	query_update( User::T, [
		new DBCol( User::PASSWORD,  $pwd,            's' ),
	], sprintf(
		'%s = %d',
		User::ID,
		$user->getUserID()
	) );
} else {
	insert_row( User::T, [
		new DBCol( User::UID,       $opts[ 'uid'  ], 's' ),
		new DBCol( User::ROLE,      $opts[ 'role' ], 's' ),
		new DBCol( User::PASSWORD,  $pwd,            's' ),
		new DBCol( User::IS_ACTIVE, 1,               'd' ),
	] );
}
