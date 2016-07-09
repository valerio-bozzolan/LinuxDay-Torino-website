<?php
// Die if called directly
defined('ABSPATH') || exit;

///////////////////////////////////////////////////////////////////
// PRON stuff
define('CONTACT_EMAIL', 'asd@example.org');
define('SERVER',     "Apache");
define('UNAME',      "Debian GNU/Linux stable");

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

define('SITE_NAME',        _("Linux Day Torino 2016") );
define('SITE_DESCRIPTION', _("15° manifestazione annuale sul software libero ed i sistemi operativi GNU/Linux.") );

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
	new MenuEntry('home',    URL,                  _("Benvenuti") ),
	new MenuEntry('credits', URL . '/credits.php', _("Crediti") )
] );

///////////////////////////////////////////////////////////////////
// Boz-PHP: On demand global objects
register_expected('LICENSES', 'Licenses');

// Common functions
require ABSPATH . INCLUDES . '/functions.php';
