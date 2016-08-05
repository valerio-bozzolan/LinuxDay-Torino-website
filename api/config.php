<?php
require_once '../load.php';

// These variables come from load.php
define('DB_USERNAME', $username);
define('DB_PASSWORD', $password);
define('DB_NAME', $database);
define('DB_HOST', $location);
define('DB_PORT', '3306');

define('DB_TIMEZONE', 'UTC');
define('OUTPUT_TIMEZONE', 'UTC');
define('OUTPUT_FILE', NULL);
define('OUTPUT_RESPONSE', true);