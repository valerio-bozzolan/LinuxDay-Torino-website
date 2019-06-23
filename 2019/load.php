<?php
# Linux Day Torino website
# Copyright (C) 2019 Valerio Bozzolan and contributors
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

/*
 * This is the boz-php configuration file
 */

define('CURRENT_CONFERENCE_UID', '2019');

// Boz-PHP: start
require '../load.php';

define('CURRENT_CONFERENCE_ROOT',                   ROOT . _  . CURRENT_CONFERENCE_UID);
define('CURRENT_CONFERENCE_URL',                    URL  . _  . CURRENT_CONFERENCE_UID);
define('CURRENT_CONFERENCE_ABSPATH', ABSPATH . __ . ROOT . __ . CURRENT_CONFERENCE_UID);

// Autoload classes
spl_autoload_register( function($c) {
	$path = CURRENT_CONFERENCE_ABSPATH . "/include/class-$c.php";
	if( is_file( $path ) ) {
		require $path;
	}
} );

define('STATIC_PATH',    CURRENT_CONFERENCE_ROOT    . _ .  'static');
define('STATIC_URL',     CURRENT_CONFERENCE_URL     . _ .  'static');
define('STATIC_ABSPATH', CURRENT_CONFERENCE_ABSPATH . __ . 'static');

define('SITE_NAME',        __("Linux Day Torino 2019") );
define('SITE_NAME_SHORT',  __("LDTO2019") );
define('SITE_DESCRIPTION', __("Manifestazione annuale sul software libero ed i sistemi operativi GNU/Linux.") );
register_js('leaflet.init', STATIC_PATH . '/leaflet-init.js');

require 'include/functions.php';
