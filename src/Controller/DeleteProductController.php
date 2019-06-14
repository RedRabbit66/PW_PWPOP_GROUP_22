<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-18
 * Time: 17:57
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteProductController
{
    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }


    public function __invoke(Request $request, Response $response, array $args)
    {

        if (isset($args['productid'])) {
            $service = $this->container->get('delete_product_repository');
            $service($args['productid']);

        } else {
            echo("No product, dont edit link!!!");
            //Error, no product
        }

        return $response->withStatus(200)->withHeader('Location', '/myproducts');
    }
}