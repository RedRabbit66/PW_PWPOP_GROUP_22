<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-28
 * Time: 21:19
 */

namespace SallePW\pwpop\Controller\Middleware;


class MailVerificationMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        //El que hauria de fer és comprovar si ha validat l'email i si no
        // mostrar un missatge al bottom de la pagina dient que verifiqui l'email
        // amb un link que pugui reenviar l'email.
        $response->getBody()->write('BEFORE');
        $next($request, $response);
        $response->getBody()->write('AFTER');

        return $response;
    }
}