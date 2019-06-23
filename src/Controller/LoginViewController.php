<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 15/04/2019
 * Time: 16:54
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class LoginViewController
{
    protected $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(Request $request, Response $response)
    {
        if (isset($_COOKIE['Sessio'])) {
            var_dump($_COOKIE['Sessio']);
            $value = $_COOKIE['Sessio'];
            $_SESSION['user_id'] = $value;
            session_start();
            $_SESSION['user_id'] = $value;
            $found = 1;
            $imageProfile = -1;

            $protocol = $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
                || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
            $url = $protocol . $_SERVER['SERVER_NAME'];

            if ($value == -1) {
                $status = 302;
                $url = $url . '/login' . '?action=login_user&status=error';

            } else {
                $_SESSION['user_id'] = $value;
                $url = $url . '/'; //. '?action=login_user&status=success';
                $status = 200;
            }

            $response = $response
                ->withStatus($status)
                ->withHeader('Location', $url);

            return $response;

        }

        $values = [];
        $params = $request->getQueryParams();
        if (isset($params['action'])) {$values['action'] = $params['action'];}
        if (isset($params['validation'])) {$values['validation'] = $params['validation'];}
        return $this->container->get('view')->render($response, 'login.html.twig', $values);

    }
}