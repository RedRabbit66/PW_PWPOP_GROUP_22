<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-18
 * Time: 10:04
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UpgradeProductController
{
    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }


    public function __invoke(Request $request, Response $response, array $args)
    {

        if (isset($args['productid'])) {


            $data = $request->getParsedBody();

            //Actualitzar info a BD

            var_dump($data);
            /*$service = $this->container->get('upgradeProduct');
            $service($args['productid']);*/


        } else {
            echo("No product, dont edit link!!!");
            //Error, no product
        }

        //return $response->withStatus(200)->withHeader('Location', '/');
    }
}