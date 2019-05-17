<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 17/05/2019
 * Time: 16:28
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class SearchProductController
{
    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response)
    {
        session_start();
        $userId = $_SESSION['user_id'];

        try {
            $inputSearch = $_SERVER['REQUEST_URI'];
            $inputSearch = substr($inputSearch, strlen('/search?search='), strlen($inputSearch));

            $service = $this->container->get('search_product_repository');
            $result = $service($inputSearch);

        } catch (\Exception $e) {
            $result = -1;
        }

        if ($result == -1) {
            $found = 0;
        } else {
            $found = 1;
        }

        return $this->container->get('view')->render($response, 'home.html.twig', ['user_id' => $userId, 'products' => $result, 'found' => $found]);
    }
}