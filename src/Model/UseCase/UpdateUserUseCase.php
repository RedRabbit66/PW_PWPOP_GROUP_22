<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 15/04/2019
 * Time: 18:12
 */

namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\UserRepository;


class UpdateUserUseCase
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

        $this->repo->updateUser();
    }
}