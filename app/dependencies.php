<?php

$container = $app->getContainer();

$container['view'] = function($container) {

    $view = new \Slim\Views\Twig(__DIR__ . '/../src/view/templates', [

        //'cache' => __DIR__ . '/../var/cache/'

    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');

    $view->addExtension(new \Slim\Views\TwigExtension($container['router'], $basePath));

    $view->getEnvironment()->addGlobal('flash', $container['flash']);

    return $view;

};

$container['mailer'] = function () {
    return new \SallePW\pwpop\Controller\PHPMailer();
};

$container['test_controller'] = function () {
  return new \SallePW\pwpop\Controller\TestController("test");
};