<?php

require_once __DIR__ . '/../bootstrap/app.php';

use GO\Scheduler;

// Create a new scheduler
$scheduler = new Scheduler();

// configure the scheduled jobs
$scheduler->raw('bin/console public-activity', [], 'public-activity')->daily();
$scheduler->raw('bin/console private-activity', [], 'private-activity')->daily();

// Let the scheduler execute jobs which are due.
$scheduler->run();