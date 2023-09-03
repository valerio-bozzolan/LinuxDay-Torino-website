<?php
# Linux Day Torino Website
# Copyright (C) 2016-2023 Valerio Bozzolan, Linux Day Torino website contributors
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

/**
 * This is the file "YEAR/load.php" and it loads important things about this conference.
 * DO NOT SAVE SECRET INFORMATION IN THIS FILE. PUT SECRETS IN ROOT's load.php INSTEAD.
 */

// Set the database user-defined identifier of this conference.
define('CURRENT_CONFERENCE_UID', '2023');

// There is also a "load.php" in the parent directory with some secrets. Load it.
require __DIR__ . '/../load.php';

// Set basic conference info. These info are localized.
define('SITE_NAME',        __("Linux Day Torino 2023") );
define('SITE_NAME_SHORT',  __("LDTO2023") );
define('SITE_DESCRIPTION', __("Manifestazione annuale sul software libero ed i sistemi operativi GNU/Linux.") );

// Set basic conference pathnames.
define('CURRENT_CONFERENCE_PATH',                   ROOT . _  . CURRENT_CONFERENCE_UID);
define('CURRENT_CONFERENCE_URL',                    URL  . _  . CURRENT_CONFERENCE_UID);
define('CURRENT_CONFERENCE_ABSPATH', ABSPATH . __ . ROOT . __ . CURRENT_CONFERENCE_UID);

// Load basic functions specific to this edition.
require 'includes/functions.php';

// Autoload classes specific to this edition.
spl_autoload_register( function( $c ) {
	$path = CURRENT_CONFERENCE_ABSPATH . __ . "/includes/{$c}.php";
	if( is_file( $path ) ) {
		require $path;
	}
} );
