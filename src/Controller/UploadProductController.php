<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 15/05/2019
 * Time: 18:02
 */

namespace SallePW\pwpop\Controller;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class UploadProductController
{
    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
}