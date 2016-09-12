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

// Die if called directly
defined('ABSPATH') || exit;

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
define('CONTENT',  ROOT . '/content');
define('INCLUDES', ROOT . '/includes');
define('XXX',      ROOT . '/static');

define('SITE_NAME',        _("Linux Day Torino") );
define('SITE_DESCRIPTION', _("Manifestazione annuale sul software libero ed i sistemi operativi GNU/Linux.") );

///////////////////////////////////////////////////////////////////
// Autoload classes
spl_autoload_register( function($c) {
	$path = ABSPATH . INCLUDES . "/class-$c.php";
	if( is_file( $path ) ) {
		require $path;
	}
} );

///////////////////////////////////////////////////////////////////
// Boz-PHP: CSS and JS (some aliases from `libjs-jquery` package)
register_js('jquery',            '/javascript/jquery/jquery.min.js');
register_js('materialize',        XXX . '/materialize/js/materialize.min.js');
register_css('materialize',       XXX . '/materialize/css/materialize.min.css');
register_css('materialize.icons', XXX . '/material-design-icons/material-icons.css');

///////////////////////////////////////////////////////////////////
// Boz-PHP: Menu entries
add_menu_entries( [
	new MenuEntry('home',       URL,                  _("Benvenuti")            ),
	new MenuEntry('credits',    URL . '/credits.php', _("Crediti")              ),
	new MenuEntry('api',        URL . '/api',         _("API"),         'hidden'),
	new MenuEntry('user',       URL . '/people',      null,             'hidden'),
	new MenuEntry('event',      URL . '/event',       null,             'hidden'),
	new MenuEntry('conference', URL . '/conference',  null,             'hidden'),
	new MenuEntry('404',        null,                 null,             'hidden')
] );

///////////////////////////////////////////////////////////////////
// Boz-PHP: On demand global objects
register_expected('LICENSES', 'Licenses');

// Common functions
require ABSPATH . INCLUDES . '/functions.php';

define('DEFAULT_IMAGE', XXX . '/gnu-linux-on-black.png');

define('ISO_LANG', get_iso_lang() );
