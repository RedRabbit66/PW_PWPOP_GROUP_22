<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-28
 * Time: 22:06
 */

namespace SallePW\pwpop\Controller\Middleware;

use Psr\Container\ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class UserLoggedMiddleware
{
    protected $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, callable $next)
    {
        if (!isset($_SESSION['id'])) {
            return $response->withStatus(302)->withHeader('Location', '/');
        }
        return $next($request, $response);
    }
}