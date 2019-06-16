<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-14
 * Time: 20:03
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProductViewController
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
    public function __invoke(Request $request, Response $response, array $args)
    {

        session_start();

        if (empty($_SESSION['user_id'])) {

            $protocol = $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
                || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
            $url = $protocol . $_SERVER['SERVER_NAME'];

            $url = $url . '/login';

            return $this->container->get('view')->render($response->withHeader('Location', $url), 'login.html.twig');

        } else{

            $user_id = $_SESSION['user_id'];

        }

        $product = NULL;
        if (isset($args['productid'])) {
            $service = $this->container->get('get_product_repository');
            $product = $service($args['productid']);


            if (!$product[0]['is_active']) {
                echo("Product not avaliable");

            } elseif ($product[0]['sold_out']){
                echo("ERROR 404 - Product sold out");
            }else{
                //echo($product[0]['title']);
                return $this->container->get('view')->render($response, 'product.html.twig', ['user_id' => $user_id, 'product' => $product]);
            }
        } else {
            echo "Error 404 - Page not found";
            //Error
           //return $this->container->get('view')->render($response, 'home.html.twig');
        }
        //return $this->container->get('view')->render($response, 'home.html.twig');
    }
}