<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-18
 * Time: 20:57
 */

namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\UserRepository;

class GetUserUseCase
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

    public function __invoke($id){

        return $this->repo->getUser($id);
    }
}