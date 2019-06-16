<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-18
 * Time: 10:05
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UpgradeProductViewController
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

        $protocol = $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
            || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['SERVER_NAME'];

        if (empty($_SESSION['user_id'])){
            $url = $url . '/login';
            return $this->container->get('view')->render($response->withHeader('Location', $url), 'login.html.twig');

        }else {

            $product = NULL;
            if (isset($args['productid'])) {

                $service = $this->container->get('get_product_repository');
                $product = $service($args['productid']);
                if($product[0]['id_user'] == $_SESSION['user_id']){

                return $this->container->get('view')->render($response, 'upgradeProduct.html.twig', ['product' => $product]);

                }else{

                    $url = $url . '/login';
                    return $this->container->get('view')->render($response->withHeader('Location', $url), 'login.html.twig');

                }

            } else {

                return $this->container->get('view')->render($response, 'home.html.twig');

            }

        }
    }
}