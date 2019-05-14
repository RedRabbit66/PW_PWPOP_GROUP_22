<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-14
 * Time: 20:03
 */

namespace SallePW\pwpop\Controller;


class ProductController
{
    public function __invoke(Request $request, Response $response, array $args)
    {
        if (isset($args['productid'])) {
            $service = $this->container->get('get_product_repository');
            $product = $service($args['productid']);

            //Hacer las tareas de comprar producto a base de datos blablabla
        } else {
            //Error
        }

        return $response->withStatus(200)->withHeader('Location', '/');
    }
}