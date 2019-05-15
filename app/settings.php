<?php
return [
  'settings' => [
      'displayErrorDetails' => true,
      'database' => [
          'dbname' => 'pwpopdb',
          'user' => 'homestead',
          'password' => 'secret',
          'host' => '192.168.10.10',
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