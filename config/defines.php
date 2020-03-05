<?php

// Path defines
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('APP_PATH', ROOT . '/app/');
define('CONFIG_PATH', ROOT . '/config/');
define('CONTROLLERS_NAMESPACE', 'App\Controllers\\');
define('MODELS_NAMESPACE', 'App\Models\\');

// App specific defines
define('APP_TIMEZONE', 'UTC');
define('APP_PHP_MIN', '7.2.0');
define('APP_PHP_MIN_ID', '70200');

// Database defines
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'beejee');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8');