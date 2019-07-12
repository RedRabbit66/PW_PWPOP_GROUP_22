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
        session_start();
        $found = 1;
        $imageProfile = -1;
        $user_id = -1;

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $service = $this->container->get('get_image_profile_repository');
            $imageProfile = $service();
        }

        $service = $this->container->get('get_products_repository');
        $products = $service();


        if($imageProfile != -1){
            $imageProfile = '/assets/images/'. $imageProfile;
        }else{
            $imageProfile = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSODALYDYo2dqN0DG_kPNi2X7EAy1K8SpRRZQWkNv9alC62IHggOw';
        }
        return $this->container->get('view')->render($response, 'home.html.twig', ['user_id' => $user_id, 'products' => $products, 'found' => $found, 'image_profile' => $imageProfile]);
    }
}