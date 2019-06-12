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
        $found = 1;
        $imageProfile = -1;

        if (empty($_SESSION['user_id'])) {
            $user_id = -1;


        } else{

            $user_id = $_SESSION['user_id'];
            try {
                $service = $this->container->get('get_image_profile_repository');
                $imageProfile = $service();
                var_dump($imageProfile);

            }catch (\Exception $e) {
//echo "hola";
            }

        }

        $service = $this->container->get('get_products_repository');
        $products = $service();


        if($imageProfile != -1){
            $imageProfile = '/../../public/assets/images/'. $imageProfile;
        }else{
            $imageProfile = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSODALYDYo2dqN0DG_kPNi2X7EAy1K8SpRRZQWkNv9alC62IHggOw';
        }

        $params = $request->getQueryParams();
        if (sizeof($params)!=0){
            $action = $params['action'];
            $status = $params['status'];
            return $this->container->get('view')->render($response, 'login.html.twig', ['action' => $action, 'statusValue' => $status, 'image_profile' => $imageProfile]);
        }

        //return $this->container->get('view')->render($response, 'home.html.twig', ['user_id' => $user_id, 'products' => $products, 'found' => $found, 'image_profile' => $imageProfile]);
    }
}