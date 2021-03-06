<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-18
 * Time: 11:51
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class MyProductsViewController
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

        session_start();

        $protocol = $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
            || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['SERVER_NAME'];

        if (empty($_SESSION['user_id'])){

            $url = $url . '/login';
            return $this->container->get('view')->render($response->withHeader('Location', $url), 'login.html.twig');

        }else{

            $user_id = $_SESSION['user_id'];

            $service = $this->container->get('get_my_products_repository');
            $products = $service();
            $found = 1;

            return $this->container->get('view')->render($response, 'myproducts.html.twig', ['user_id' => $user_id, 'products' => $products, 'found' => $found]);

        }

    }
}