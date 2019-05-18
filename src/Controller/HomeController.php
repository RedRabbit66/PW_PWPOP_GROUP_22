<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 13/04/2019
 * Time: 11:41
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class HomeController
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
       /* if(session_status() == "PHP_SESSION_ACTIVE "){
            session_start();
        }*/
        session_start();

        //echo($_SESSION['user_id']);

        if (empty($_SESSION['user_id'])) {
            $user_id = -1;
            //echo($user_id);


        } else{
            $user_id = $_SESSION['user_id'];
        }

        $service = $this->container->get('get_products_repository');
        $products = $service();

        return $this->container->get('view')->render($response,
            'home.html.twig',
            ['user_id' => $user_id, 'products' => $products]);
    }

}