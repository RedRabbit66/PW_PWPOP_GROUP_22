<?php

$app->get('/', 'SallePW\pwpop\Controller\HomeController');
$app->post('/loginuser', 'SallePW\pwpop\Controller\LoginController');
$app->post('/registeruser', 'SallePW\pwpop\Controller\RegisterController');
