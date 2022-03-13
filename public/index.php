<?php

require_once __DIR__ . '/../bootstrap/app.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

use App\Core\Application;

$app = new Application;

// routes for handling web requests
require_once '../routes/web.php';

// routes for handling api requests
require_once '../routes/api.php';

try {
    echo $app->run();
} catch (Exception $e) {
}