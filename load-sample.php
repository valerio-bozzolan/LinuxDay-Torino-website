<?php
// Database table prefix, if any.
// E.g. 'asd_'
// Anyway in this example you don't need tables
$prefix = '';

// Specify the folder of your site after the domain name.
// NO TRAILING SLASH
// E.g. '/blog/01'
define('ROOT', '');

// It enables extra verbose framework errors like wrong database password
define('DEBUG', true);

define('ABSPATH', __DIR__ );

// Where is the framework? It should be always there:
require '/usr/share/boz-php-another-php-framework/load.php';
