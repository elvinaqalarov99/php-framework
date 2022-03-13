<?php

/** @var Application $app */

use App\Core\Application;

$app->router->get('/', function () {
    return 'Hello World';
});