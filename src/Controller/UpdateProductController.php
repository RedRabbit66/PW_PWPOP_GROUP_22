<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-18
 * Time: 10:04
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use \Psr\Http\Message\UploadedFileInterface;
use \Hashids\Hashids;


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateProductController
{
    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }


    public function __invoke(Request $request, Response $response, array $args)
    {

        if (isset($args['productid'])) {

            $data = $request->getParsedBody();
            $service = $this->container->get('update_product_repository');
            $service($args['productid'], $data['uploadProduct_Name'], $data['uploadProduct_Description'], $data['uploadProduct_Price'], $data['uploadProduct_Category']);

        } else {
            echo("No product, don't edit url!!!");
            //Error, no product
        }
        return $response->withStatus(200)->withHeader('Location', '/');
    }


    public function validateProductUpload(){
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($_POST as $data => $val) {

                if ($data == 'uploadProduct_Name') {
                    if (strlen($val) == 0) {
                        $errors['uploadProduct_Name'] = "Title field is required";
                    }
                } elseif ($data == 'uploadProduct_Description') {
                    if (strlen($val) == 0) {
                        $errors['uploadProduct_Description'] = "Product description field is required";
                    } elseif (strlen($val) < 20) {
                        $errors['uploadProduct_Description'] = "Product description field must be at least 20 characters long";
                    }
                } elseif ($data == 'uploadProduct_Category') {
                    if (strcmp($val, "empty") == 0) {
                        $errors['uploadProduct_Category'] = "You must choose a product category";
                    }
                } elseif ($data == 'uploadProduct_Price') {
                    if (($val < 0) || !preg_match("/^[0-9]+$/", $val)) {
                        $errors['uploadProduct_Price'] = "Price must be a valid integer positive value";
                    }
                }
            }
        }
        return $errors;
    }

}