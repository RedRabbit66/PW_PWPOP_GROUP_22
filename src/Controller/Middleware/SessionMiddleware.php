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
    public function __invoke(Request $request, Response $response, callable $next)
    {
        session_start();

        if (session_status() == PHP_SESSION_ACTIVE) {
            if (isset($_SESSION['user_id'])) {
                $protocol = $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
                    || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';

                return $response->withHeader('Location', $protocol . $_SERVER['SERVER_NAME'] . '/' . $_SESSION['root_folder']);
            }
            return $next($request, $response);
        }
    }
}