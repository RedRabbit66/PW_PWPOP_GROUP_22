<?php

$app->get('/', 'SallePW\pwpop\Controller\HomeController')->add(\SallePW\pwpop\Controller\Middleware\SessionMiddleware::class);
$app->get('/login', 'SallePW\pwpop\Controller\LoginViewController');
$app->post('/login', 'SallePW\pwpop\Controller\LoginController');
$app->get('/register', 'SallePW\pwpop\Controller\RegisterViewController');
$app->post('/register', 'SallePW\pwpop\Controller\RegisterController');
$app->get('/profile', 'SallePW\pwpop\Controller\UpdateUserViewController')->add(\SallePW\pwpop\Controller\Middleware\UserLoggedMiddleware::class);
$app->post('/updateuser', 'SallePW\pwpop\Controller\UpdateUserController');
$app->post('/deleteuser', 'SallePW\pwpop\Controller\DeleteUserController');
$app->get('/logout', 'SallePW\pwpop\Controller\LogoutController');

/*$app->get('/logout', function(Request $request, Response $response) {
    $_SESSION['id'] = null;
    return $response->withStatus(302)->withHeader('Location', '/');
});*/

$app
    ->post('/files', FileController::class . ':uploadAction')
    ->setName('upload');

$app->get('/Activation_mail[/{key}]', '\Pwbox\controller\ActivationMailController');