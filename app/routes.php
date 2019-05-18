<?php

$app->get('/', 'SallePW\pwpop\Controller\HomeController');//->add('\SallePW\pwpop\Controller\Middleware\SessionMiddleware');
$app->get('/login', 'SallePW\pwpop\Controller\LoginViewController');
$app->post('/login', 'SallePW\pwpop\Controller\LoginController');
$app->get('/register', 'SallePW\pwpop\Controller\RegisterViewController');
$app->post('/register', 'SallePW\pwpop\Controller\RegisterController');
$app->get('/profile', 'SallePW\pwpop\Controller\UpdateUserViewController');
$app->post('/updateuser', 'SallePW\pwpop\Controller\UpdateUserController');
$app->post('/deleteuser', 'SallePW\pwpop\Controller\DeleteUserController');
$app->get('/logout', 'SallePW\pwpop\Controller\LogoutController');
$app->get('/uploadproduct', 'SallePW\pwpop\Controller\UploadProductViewController');
$app->post('/uploadproduct', 'SallePW\pwpop\Controller\UploadProductController');
$app->get('/upgradeProduct[/{productid}]', 'SallePW\pwpop\Controller\UpgradeProductViewController');
$app->post('/upgradeProduct[/{productid}]', 'SallePW\pwpop\Controller\UpgradeProductController');
$app->get('/product[/{productid}]', 'SallePW\pwpop\Controller\ProductViewController');
$app->post('/product[/{productid}]', 'SallePW\pwpop\Controller\ProductController');
$app->post('/buy[/{productid}]', 'SallePW\pwpop\Controller\ProductController');
$app->get('/search', 'SallePW\pwpop\Controller\SearchProductController');
$app->get('/MyProducts', 'SallePW\pwpop\Controller\MyProductsViewController');
$app->post('/MyProducts', 'SallePW\pwpop\Controller\MyProductsController');
$app->get('/Myproduct[/{productid}]', 'SallePW\pwpop\Controller\MyProductViewController');
$app->post('/Myproduct[/{productid}]', 'SallePW\pwpop\Controller\MyProductController');



/*$app->get('/logout', function(Request $request, Response $response) {
    $_SESSION['id'] = null;
    return $response->withStatus(302)->withHeader('Location', '/');
});*/

$app->post('/files',  ImageUploadController::class . ':uploadAction')->setName('upload');

$app->get('/Activation_mail[/{key}]', 'SallePW\pwpop\controller\ActivationMailController');