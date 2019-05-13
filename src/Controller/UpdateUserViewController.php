<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 15/04/2019
 * Time: 17:23
 */

namespace SallePW\pwpop\Controller;

use \Psr\Container\ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


class UpdateUserViewController
{
    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response) {
        session_start();
        if (session_status() == PHP_SESSION_ACTIVE) {
            if (isset($_SESSION['user_id'])) {
                $service = $this->container->get('search_user_repository');
                $user = $service();
                $protocol = $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
                    || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';


                $url = $protocol . $_SERVER['SERVER_NAME'];
                $action = $request->getQueryParam('action');
                $statusMessage = $request->getQueryParam('status');

                return $this->container->get('view')->render($response, 'updateUser.html.twig',
                    ['name' => $user['name'], 'username' => $user['username'],  'email' => $user['email'],
                        'birthday' => $user['birthday'], 'phone_number' => $user['phone_number'], 'url' => $url,
                        'action' => $action, 'statusMessage' => $statusMessage]);
            }
        }
    }
}