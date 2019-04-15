<?php

$app->get('/', 'SallePW\pwpop\Controller\HomeController');
$app->get('/login', 'SallePW\pwpop\Controller\LoginViewController');
$app->post('/login', 'SallePW\pwpop\Controller\LoginController');
$app->get('/register', 'SallePW\pwpop\Controller\RegisterViewController');
$app->post('/register', 'SallePW\pwpop\Controller\RegisterController');
$app->get('/profile', 'SallePW\pwpop\Controller\UpdateUserViewController');
$app->post('/updateuser', 'SallePW\pwpop\Controller\UpdateUserController');
$app->post('/deleteuser', 'SallePW\pwpop\Controller\DeleteUserController');
$app->get('/logout', 'SallePW\pwpop\Controller\LogoutController');
