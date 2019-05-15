<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 13/04/2019
 * Time: 13:03
 */

namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\User;
use SallePW\pwpop\Model\UserRepository;

class PostUserUseCase
{
    /** @var UserRepository */
    private $repo;

    /**
     * PostUserUseCase constructor.
     * @param UserRepository $repo
     */
    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function __invoke(array $rawData){
        $user = new User(
            //En las comillas hay que poner el tag 'name' del html no el 'id'
            $rawData['name'],
            $rawData['username'],
            $rawData['email'],
            $rawData['birthday'],
            $rawData['phoneNumber'],
            $rawData['password'],
            $rawData['profileImage']

        );

        $this->repo->saveUser($user);
    }
}