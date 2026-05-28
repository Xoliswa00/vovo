<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = '/home/nobelab3c3p6/repositories/vovo/storage/framework/maintenance.php')) {
    require $maintenance;
}
require __DIR__ . '/../repositories/Nobela/vendor/autoload.php';

$app = require_once __DIR__.'/../vovo/bootstrap/app.php';

// In your index.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$app = require_once  '/home/nobelab3c3p6/repositories/vovo/bootstrap/app.php';


$app->handleRequest(Request::capture());
