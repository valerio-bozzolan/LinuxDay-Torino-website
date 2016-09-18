<?php
# Linux Day 2016 - Example Boz-PHP configuration file
# Copyright (C) 2016 Valerio Bozzolan
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

// Database info
$database = 'insert-here-database-name';
$username = 'insert-here-database-username';
$password = 'insert-here-database-password';
$location = 'localhost';

// Database table prefix (if any)
// E.g. 'asd_'
// Keep in mind that "tagliatella" doesn't support this, so it's probably better to leave an empty string here.
$prefix = '';

// See also include/class-Talk.php for track\area names!

// Enable extra verbose framework errors
define('DEBUG', true);

// Absolute pathname to the folder of the project
// NO TRAILING SLASH
define('ABSPATH', __DIR__ );

// User for events
define('DB_TIMEZONE', 'Europe/Rome');

// Path to Boz-PHP/load.php
require '/usr/share/boz-php-another-php-framework/load.php';
