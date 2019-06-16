<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 15/05/2019
 * Time: 18:01
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



class UploadProductViewController
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

            return $this->container->get('view')->render($response, 'uploadProduct.html.twig');

        }
    }
}