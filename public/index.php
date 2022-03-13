<?php

require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Application;

$app = new Application;

$app->router->get('/', function (...$args) {
    return 'Hello World';
});

$app->router->get('/users', function (...$args) {
    return 'Hello Users';
});

echo $app->run();