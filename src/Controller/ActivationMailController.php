<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-28
 * Time: 20:56
 */

namespace SallePW\pwpop\Controller;


class ActivationMailController
{
    protected $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $checkVerificationService = $this->container->get('check_verification_service');
        $userId = $checkVerificationService($args['key']);

        if (!$userId) {
            echo("key not valid");
        } else {
            $_SESSION['id'] = $userId;
            $updateVerifiedService = $this->container->get('update_verified_service');
            $updateVerifiedService($userId);

            $this->container->get('flash')->addMessage('user_verify', 'The email has been succesfully verified');

            return $response->withStatus(302)->withHeader('Location', '/dashboard');
        }

    }
}