<?php
# Linux Day 2016 - Boz-PHP configuration
# Copyright (C) 2016, 2017 Valerio Bozzolan, Linux Dau Torino
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

// Die if called directly
defined('BOZ_PHP') or exit;

define('INCLUDES', 'includes');

// Autoload classes
spl_autoload_register( function($c) {
	$path = ABSPATH . __ . INCLUDES . __ . "class-$c.php";
	if( is_file( $path ) ) {
		require $path;
	}
} );

// One day I will push these 2 functions in Boz-PHP
require ABSPATH . '/includes/functions.php';

// Boz-PHP: On demand global objects
register_expected('LICENSES', 'Licenses');

register_permissions('user',    'edit-account');
inherit_permissions( 'admin',   'user');
register_permissions('admin',   'edit-users');
register_permissions('admin',   'edit-events');

defined('LATEST_CONFERENCE_UID')
	or define('LATEST_CONFERENCE_UID', '2017');

defined('CURRENT_CONFERENCE_UID')
	or define('CURRENT_CONFERENCE_UID', LATEST_CONFERENCE_UID);

defined('REPO')
	or define('REPO', 'https://github.com/LinuxDayTorino/LinuxDay-Torino-website');

defined('LIBMARKDOWN_PATH')
	or define('LIBMARKDOWN_PATH', '/usr/share/php/markdown.php');

defined('JQUERY')
	or define('JQUERY', '/javascript/jquery/jquery.min.js');

defined('LEAFLET_DIR')
	or define('LEAFLET_DIR', '/javascript/leaflet');

defined('NOINDEX')
	or define('NOINDEX', false);

// /{conference_uid}/
defined('PERMALINK_CONFERENCE')
	or define('PERMALINK_CONFERENCE', '/%s/');

 // /{conference_uid}/{$chapter_uid}/{event_uid}
defined('PERMALINK_EVENT')
	or define('PERMALINK_EVENT', '/%1$s/%3$s/%2$s');

// /2016/{user_uid}
defined('PERMALINK_USER')
	or define('PERMALINK_USER', '/%1$s/user/%2$s');

defined('FORCE_PERMALINK')
	or define('FORCE_PERMALINK', 1);

register_js('jquery',   JQUERY);
register_js('leaflet',  LEAFLET_DIR . '/leaflet.js');
register_css('leaflet', LEAFLET_DIR . '/leaflet.css');
