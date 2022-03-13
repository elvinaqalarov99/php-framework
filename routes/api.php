<?php

/** @var Application $app */

use App\Core\Application;
use App\Http\Controllers\ActivityController;

$app->router->get('/api', function () {
    return 'Hello World1';
});

$app->router->get('/api/activities', [ActivityController::class, 'index']);