<?php
$container = $app->getContainer();

$container['view'] = function($container){
    $view = new \Slim\Views\Twig(__DIR__ . '/../src/view/templates', []);
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($container['router'], $basePath));
    return $view;
};

$container['doctrine'] = function($container){
    $config = new \Doctrine\DBAL\Configuration();
    $conn = \Doctrine\DBAL\DriverManager::getConnection(
        $container->get('settings')['database'],
        $config
    );
    return $conn;
};

$container['user_repository'] = function ($container){
    $repository = new SallePW\pwpop\Model\Implementation\DoctrineUserRepository(
        $container->get('doctrine')
    );
    return $repository;
};

$container['post_user_repository'] = function ($container){
    $service = new SallePW\pwpop\Model\UseCase\PostUserUseCase(

        $container->get('user_repository')
    );
    return $service;
};

$container['check_user_repository'] = function ($container){
    $service = new SallePW\pwpop\Model\UseCase\CheckUserUseCase(
        $container->get('user_repository')
    );
    return $service;
};

$container['search_user_repository'] = function ($container){
    $service = new SallePW\pwpop\Model\UseCase\SearchUserUseCase(
        $container->get('user_repository')
    );
    return $service;
};


$container['update_user_repository'] = function ($container){
    $service = new SallePW\pwpop\Model\UseCase\UpdateUserUseCase(
        $container->get('user_repository')
    );
    return $service;
};

$container['delete_user_repository'] = function ($container){
    $service = new SallePW\pwpop\Model\UseCase\DeleteUserUseCase(
        $container->get('user_repository')
    );
    return $service;
};

