<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 15/04/2019
 * Time: 17:29
 */

namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\UserRepository;

class SearchUserUseCase
{
    private $repo;

    public function __construct(UserRepository $repo) {
        $this->repo = $repo;
    }

    public function __invoke() {
        return $this->repo->searchUser();
    }
}