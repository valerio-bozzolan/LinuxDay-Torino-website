<?php
# Linux Day 2017 - Boz-PHP configuration
# Copyright (C) 2017 Valerio Bozzolan, Linux Day Torino
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

// Boz-PHP: start
require '../load.php';

// Conference directory in ROOT path
define('CONFERENCE_DIR', '/2017');

// Conference URI directory
define('CONFERENCE', ROOT . CONFERENCE_DIR);

define('REPO', 'https://github.com/0iras0r/ld2017');

// Autoload classes
spl_autoload_register( function($c) {
	$path = ABSPATH . CONFERENCE_DIR . "/includes/class-$c.php";
	if( is_file( $path ) ) {
		require $path;
	}
} );

require 'includes/functions.php';

define('TEXT', 'purple-text text-darken-4');
define('BACK', 'purple darken-4');

///////////////////////////////////////////////////////////////////
// Boz-PHP: GNU Gettext configuration
define('GETTEXT_DOMAIN',         'linuxday');
define('GETTEXT_DIRECTORY',      'l10n');
define('GETTEXT_DEFAULT_ENCODE', 'utf8');

register_language('en_US', ['en', 'en-us', 'en-en'] );
register_language('it_IT', ['it', 'it-it'] );

$l = null;
if( isset( $_REQUEST['l'] ) ) {
	$l = $_REQUEST['l'];
}
define('LANGUAGE_APPLIED', apply_language( $l ) );

///////////////////////////////////////////////////////////////////
define('STATIC_DIR', '/static');

// Boz-PHP: Helpful constants
define('XXX', CONFERENCE . STATIC_DIR);

define('SITE_NAME',        _("Linux Day Torino 2017") );
define('SITE_NAME_SHORT',  _("LDTO2017") );
define('SITE_DESCRIPTION', _("Manifestazione annuale sul software libero ed i sistemi operativi GNU/Linux.") );

///////////////////////////////////////////////////////////////////
// Boz-PHP: CSS and JS (some aliases from `libjs-jquery` package)
register_js('jquery',              JQUERY);
register_js('leaflet',             LEAFLET_DIR . '/leaflet.js');
register_js('leaflet.init',        XXX . '/leaflet-init.js');
register_js('materialize',         XXX . '/materialize/js/materialize.min.js');
register_css('leaflet',            LEAFLET_DIR . '/leaflet.css');
register_css('materialize',        XXX . '/materialize/css/materialize.min.css');
register_css('materialize.custom', XXX . '/materialize-custom.css');
register_css('materialize.icons',  XXX . '/material-design-icons/material-icons.css');
register_css('home',               XXX . '/home.css');
register_js('scrollfire',          XXX . '/scrollfire.js');

///////////////////////////////////////////////////////////////////
// Boz-PHP: Menu entries
add_menu_entries( [
	new MenuEntry('user',        null, null, 'hidden'),
	new MenuEntry('event',       null, null, 'hidden'),
	new MenuEntry('conference',  null, null, 'hidden'),
	new MenuEntry('404',         null, null, 'hidden'),

	new MenuEntry('home',    URL . CONFERENCE . _,               _("Benvenuti")             ),
//	new MenuEntry('partner', URL . CONFERENCE . '/partner.php',  _("Partner")               ),
//	new MenuEntry('photos',  URL . CONFERENCE . '/photos.php',   _("Fotografie")            ),
//	new MenuEntry('credits', URL . CONFERENCE . '/credits.php',  _("Crediti")               ),
	new MenuEntry('api',     URL . CONFERENCE . '/api',          _("API"),          'hidden')
] );

define('DEFAULT_IMAGE', XXX . '/gnu-linux-on-black.png');
