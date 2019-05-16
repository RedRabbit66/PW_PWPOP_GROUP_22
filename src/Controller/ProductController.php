<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-14
 * Time: 20:03
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;

use SallePW\pwpop\Model\UseCase\SendMailUseCase;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProductController
{

    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }


    public function __invoke(Request $request, Response $response, array $args)
    {

        if (isset($args['productid'])) {
            $service = $this->container->get('get_product_repository');
            $product = $service($args['productid']);



            if($product[0]['sold_out']){
                //No hay disponibles
                $soldOut = 1;

            }else{
                //Restar 1 en el stock ($soldOut = 1) en sql
                $service = $this->container->get('set_product_soldout_repository');
                $service($product[0]['id']);
                $productPropietary = $product[0]['user_id'];

                if(session_status() == PHP_SESSION_ACTIVE){
                    session_start();
                }

                $service = $this->container->get('search_user_repository');
                $user = $service();

                $username = $user['username'];
                $to = $user['email'];
                //$message = "Your product has been buyed! by " . $user['username'] . "\n Get in contact with him with his email: " . $user['email'];


                //Enviar mail
                $service = $this->container->get('send_mail_service');
                $service($username, $to, "Hi :)");



            }

        } else {
            echo("No product, dont edit link!!!");
            //Error, no product
        }

        //return $response->withStatus(200)->withHeader('Location', '/');
    }
}