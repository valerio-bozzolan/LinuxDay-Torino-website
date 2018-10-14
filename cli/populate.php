#!/usr/bin/php
<?php
# Linux Day - command line interface to upgrade the database
# Copyright (C) 2018 Valerio Bozzolan
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

// allowed only from command line interface
isset( $argv[ 0 ] ) or exit( 1 );

// autoload the framework
require __DIR__ . '/../load.php';

// import the database schema
multiquery( file_get_contents( ABSPATH . '/documentation/database/database-schema.sql' ) );
