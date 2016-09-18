<?php
# Linux Day 2016 - Boz-PHP configuration
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

// Boz-PHP: URL const
define('ROOT', '/2016');

// Boz-PHP: start
require '../load.php';

// Autoload classes
spl_autoload_register( function($c) {
	$path = ABSPATH . ROOT . "/includes/class-$c.php";
	if( is_file( $path ) ) {
		require $path;
	}
} );

require 'includes/functions.php';

///////////////////////////////////////////////////////////////////
// Boz-PHP: GNU Gettext configuration
define('GETTEXT_DOMAIN',         'linuxday');
define('GETTEXT_DIRECTORY',      'l10n');
define('GETTEXT_DEFAULT_ENCODE', 'UTF-8');

register_language('en_US', ['en', 'en-us', 'en-en'] );
register_language('it_IT', ['it', 'it-it'] );

$l = 'it';
if( isset( $_REQUEST['l'] ) ) {
	$l = $_REQUEST['l'];
}
define('LANGUAGE_APPLIED', apply_language( $l ) );

///////////////////////////////////////////////////////////////////
// Boz-PHP: Helpful constants
define('XXX',     ROOT  . '/static');

define('SITE_NAME',        _("Linux Day Torino 2016") );
define('SITE_NAME_SHORT',  _("LDTO2016") );
define('SITE_DESCRIPTION', _("Manifestazione annuale sul software libero ed i sistemi operativi GNU/Linux.") );

///////////////////////////////////////////////////////////////////
// Boz-PHP: CSS and JS (some aliases from `libjs-jquery` package)
register_js('jquery',             '/javascript/jquery/jquery.min.js');
register_js('leaflet',            '/javascript/leaflet/leaflet.js');
register_js('leaflet',            '/javascript/leaflet/leaflet.js');
register_js('leaflet.init',       XXX . '/leaflet-init.js');
register_js('materialize',        XXX . '/materialize/js/materialize.min.js');
register_css('leaflet',            '/javascript/leaflet/leaflet.css');
register_css('materialize',       XXX . '/materialize/css/materialize.min.css');
register_css('materialize.icons', XXX . '/material-design-icons/material-icons.css');
register_css('animation',         XXX . '/animation.css');

///////////////////////////////////////////////////////////////////
// Boz-PHP: Menu entries
add_menu_entries( [
	new MenuEntry('user',        null, null, 'hidden'),
	new MenuEntry('event',       null, null, 'hidden'),
	new MenuEntry('conference',  null, null, 'hidden'),
	new MenuEntry('404',         null, null, 'hidden'),

	new MenuEntry('home',          URL,                        _("Benvenuti")             ),
	new MenuEntry('media-partner', URL . '/media-partner.php', _("Media partner")         ),
	new MenuEntry('credits',       URL . '/credits.php',       _("Crediti")               ),
	new MenuEntry('api',           URL . '/api',               _("API"),          'hidden')

] );

define('ISO_LANG', get_iso_lang() );

define('DEFAULT_IMAGE', XXX . '/gnu-linux-on-black.png');
