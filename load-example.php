<?php
# Linux Day - Example Boz-PHP configuration file
# Copyright (C) 2016, 2018 Valerio Bozzolan
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

// Request URI pathname of the complete website
// NO TRAILING SLASH
// E.g. '/linux-day'
define('ROOT', '');

// used for events
define('DB_TIMEZONE', 'Europe/Rome');

// contact informations
define('CONTACT_EMAIL',        'asd@asd.asd'    );
define('CONTACT_PHONE',        '555-55-55-55'   );
define('CONTACT_PHONE_PREFIX', '+39'            );

// which file should be loaded after boz-php
define('REQUIRE_LOAD_POST', ABSPATH . '/includes/load-post.php' );

// load boz-php
require '/usr/share/boz-php-another-php-framework/load.php';
