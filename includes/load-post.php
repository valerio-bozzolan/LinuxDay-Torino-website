<?php
# Linux Day 2016 - Boz-PHP configuration
# Copyright (C) 2016, 2017, 2018, 2019 Valerio Bozzolan, Linux Day Torino
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

// Custom Sessionuser class
define('SESSIONUSER_CLASS', 'User');

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

// user permissions
register_permissions( 'user', [] );

// admin permissions
inherit_permissions( 'admin',   'user', [
	'add-event',
	'edit-users',
	'edit-events',
] );

define_default( 'LATEST_CONFERENCE_UID', '2019' );

define_default( 'CURRENT_CONFERENCE_UID', LATEST_CONFERENCE_UID );

define_default( 'CONTACT_PHONE_PREFIX', '+39' );

define_default( 'REPO', 'https://github.com/LinuxDayTorino/LinuxDay-Torino-website' );

define_default( 'LIBMARKDOWN_PATH', '/usr/share/php/markdown.php' );

define_default( 'JQUERY', '/javascript/jquery/jquery.min.js' );

define_default( 'LEAFLET_DIR', '/javascript/leaflet' );

define_default( 'NOINDEX', false );

// /{conference_uid}/
define_default( 'PERMALINK_CONFERENCE', '%s/' );

 // /{conference_uid}/{$chapter_uid}/{event_uid}
define_default( 'PERMALINK_EVENT', '%1$s/%3$s/%2$s' );

// /2016/{user_uid}
define_default( 'PERMALINK_USER', '%1$s/user/%2$s' );

define_default( 'FORCE_PERMALINK', 1 );

// timezone of database dates
define_default( 'DEFAULT_TIMEZONE', 'Europe/Rome' );

register_js( 'jquery', JQUERY );

register_js(  'leaflet', LEAFLET_DIR . '/leaflet.js' );

register_css( 'leaflet', LEAFLET_DIR . '/leaflet.css' );

register_js('typed',  ROOT . '/2017/static/typed/typed.min.js');

// GNU Gettext configuration
define( 'GETTEXT_DOMAIN', 'linuxday' );
define( 'GETTEXT_DIRECTORY', ABSPATH . __ . 'l10n' );
define( 'GETTEXT_DEFAULT_ENCODE', 'utf8' );

// register languages
register_language( 'en_US', ['en', 'en-us', 'en-en'], null, null, 'English'  );
register_language( 'it_IT', ['it', 'it-it'],          null, null, 'Italiano' );
register_default_language( 'it_IT' );

// apply the global timezone
date_default_timezone_set( DEFAULT_TIMEZONE );

// apply a language for this request only
if( isset( $_GET[ 'l' ] ) ) {
	apply_language( $_GET['l'] );
} else {
	// as last resource, take from browser language
	apply_language();
}
