<?php

require_once __DIR__ . '/../bootstrap/app.php';

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