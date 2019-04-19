<?php

return [
  'settings' => [
      'displayErrorDetails' => true,
      'database' => [
          'dbname' => 'pwpopdb',
          'user' => 'root',
          'password' => '',
          'host' => '127.0.0.1',
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