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
        $params = $request->getQueryParams();
        if (sizeof($params)!=0){
            $action = $params['action'];
            $status = $params['status'];
            return $this->container->get('view')->render($response, 'login.html.twig', ['action' => $action, 'statusValue' => $status, 'LoginFail' => '0']);
        }

        return $this->container->get('view')->render($response, 'login.html.twig');
    }
}