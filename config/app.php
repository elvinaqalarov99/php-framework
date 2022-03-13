<?php

return [
  'database' => [
      'host'     => $_ENV['DB_HOST'] ?? 'localhost',
      'user'     => $_ENV['DB_USER'] ?? 'root',
      'password' => $_ENV['DB_PASSWORD'] ?? '',
      'name'     => $_ENV['DB_NAME'] ?? '',
  ]
];