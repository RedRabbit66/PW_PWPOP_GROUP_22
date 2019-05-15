<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-14
 * Time: 20:03
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
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
                //Restar 1 en el stock
                //enviar mail
            }
            //Hacer las tareas de comprar producto a base de datos blablabla
        } else {
            //Error, no product
        }

        return $response->withStatus(200)->withHeader('Location', '/');
    }
}