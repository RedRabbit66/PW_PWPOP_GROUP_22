<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-11
 * Time: 21:33
 */

namespace SallePW\pwpop\Controller;


use Psr\Container\ContainerInterface;

class HelloController
{
    /** @var ContainerInterface */
    private $container;

    /**
     * HelloController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke()
    {
        /** @var Mailer $mailer */
        $mailer = $this->container->get('mailer');

        $mailer->sendMail("user", "to", "message");
    }
}