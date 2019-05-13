<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 13/04/2019
 * Time: 12:54
 */

namespace SallePW\pwpop\Controller\Middleware;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class SessionMiddleware
{
    public function __construct()
    {
    }

    public function __invoke(Request $request, Response $response, callable $next)
    {
        session_start();
        return $next($request, $response);
    }
}