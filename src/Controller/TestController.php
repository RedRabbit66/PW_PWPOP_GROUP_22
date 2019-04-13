<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-11
 * Time: 21:26
 */

namespace SallePW\pwpop\Controller;


class TestController
{
    private $nom;

    public function __construct(string $nom)
    {
        $this->nom = $nom;
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }


    public function testAction()
    {
        echo $this->nom;
    }
}