<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 15/04/2019
 * Time: 16:55
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class RegisterViewController
{
    private $container;

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
        $values = [];

        $params = $request->getQueryParams();
        if (isset($params['action'])) {$values['action'] = $params['action'];}
        if (isset($params['validation'])) {$values['validation'] = $params['validation'];}

        return $this->container->get('view')->render($response, 'register.html.twig', $values);
    }
}