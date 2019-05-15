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

$container['phpmailer'] = function($container) {
    $settings = $container->get('settings')['mailer'];

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);                              // Passing `true` enables exceptions
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $settings['host'];  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $settings['username'];                 // SMTP username
    $mail->Password = $settings['password'];                           // SMTP password
    $mail->SMTPSecure = $settings['encryption'];                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = $settings['port'];

    $mail->setFrom($settings['username'], 'Mailer');

    return $mail;
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

$container['send_mail_service'] = function($container) {
    $service = new SallePW\pwpop\Model\Services\SendMailService(
        $container->get('mailer_repository')
    );

    return $service;
};

$container['post_verification_key_service'] = function($container) {
    $service = new SallePW\pwpop\Model\Services\PostVerificationKeyService(
        $container->get('user_repository')
    );

    return $service;
};

$container['check_verification_service'] = function($container) {
    $service = new SallePW\pwpop\Model\Services\CheckVerificationService(
        $container->get('user_repository')
    );

    return $service;
};

$container['update_verified_service'] = function($container) {
    $service = new SallePW\pwpop\Model\Services\UpdateVerifiedService(
        $container->get('user_repository')
    );

    return $service;
};


$container['product_repository'] = function ($container){
    $repository = new SallePW\pwpop\Model\Implementation\DoctrineProductRepository(
        $container->get('doctrine')
    );
    return $repository;
};

$container['post_file_repository'] = function ($container){
    $service = new SallePW\pwpop\Model\UseCase\PostProductUseCase(
        $container->get('product_repository')
    );
    return $service;
};

$container['delete_file_repository'] = function ($container){
    $service = new SallePW\pwpop\Model\UseCase\DeleteProductUseCase(
        $container->get('product_repository')
    );
    return $service;
};

$container['update_file_repository'] = function ($container){
    $service = new SallePW\pwpop\Model\UseCase\UpdateProductUseCase(
        $container->get('product_repository')
    );
    return $service;
};


$container['get_products_repository'] = function ($container){
    $service = new SallePW\pwpop\Model\UseCase\GetProductsUseCase(
        $container->get('product_repository')
    );
    return $service;
};

$container['get_product_repository'] = function ($container){
    $service = new SallePW\pwpop\Model\UseCase\GetProductUseCase(
        $container->get('product_repository')
    );
    return $service;
};

$container['set_product_soldout_repository'] = function ($container){
    $service = new SallePW\pwpop\Model\UseCase\SetProductSoldOutsUseCase(
        $container->get('product_repository')
    );
    return $service;
};