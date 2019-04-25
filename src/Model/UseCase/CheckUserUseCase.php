<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 14/04/2019
 * Time: 18:19
 */

namespace SallePW\pwpop\Model\UseCase;
use SallePW\pwpop\Model\UserRepository;

class CheckUserUseCase
{
    /** @var UserRepository */
    private $repo;

    /**
     * PostUserUseCase constructor.
     * @param UserRepository $repo
     */
    public function __construct(UserRepository $repo) {
        $this->repo = $repo;
    }

    public function __invoke(array $rawData){

        return $this->repo->getUserId($rawData['email'], md5($rawData['password']));
    }
}