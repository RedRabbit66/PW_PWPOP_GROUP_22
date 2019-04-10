<?php

return [
  'settings' => [
      'displayErrorDetails' => true,
      'database' => [
          'dbname' => 'pwpop',
          'user' => 'root',
          'password' => '1234',
          'host' => 'localhost',
          'driver' => 'pdo_mysql'
      ],
      'mailer' => [
          "host" => "smtp.outlook.com",
          "port" => 587,
          "username" => "pwpop22@outlook.com",
          "password" => "PW-22-pwpop",
          "encryption" => "tls",
      ]
  ]
];