<?php declare(strict_types=1);

date_default_timezone_set("UTC");
session_start();

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

if (getenv("DEBUG")) {
    error_reporting(E_ALL);
    ini_set("display_errors", "true");
}

// Instantiate the app
$settings = require __DIR__ . '/config/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/config/dependencies.php';

// Register middleware
require __DIR__ . '/config/middleware.php';

// Register routes
require __DIR__ . '/routes/default.php';

// Run app
$app->run();
