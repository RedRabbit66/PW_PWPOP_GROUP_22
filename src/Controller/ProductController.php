<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-14
 * Time: 20:03
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;

use SallePW\pwpop\Controller\Mailer;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProductController
{
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
                if(session_status() == PHP_SESSION_ACTIVE){
                    session_start();
                }

                $service = $this->container->get('search_user_repository');
                $user = $service();

                $email = $user[0]['email'];

                echo ($email);

                //Enviar mail
            }
            //Hacer las tareas de comprar producto a base de datos blablabla
        } else {
            echo("No product, dont edit link!!!");
            //Error, no product
        }

        //return $response->withStatus(200)->withHeader('Location', '/');
    }
}