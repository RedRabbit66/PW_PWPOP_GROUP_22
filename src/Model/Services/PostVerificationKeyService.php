<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-28
 * Time: 21:42
 */

namespace SallePW\pwpop\Model\Services;

use SallePW\pwpop\Model\UserRepository;

class PostVerificationKeyService
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * PostUserService constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($userId, $verificationKey)
    {
        $this->repository->insertVerificationKey($userId, $verificationKey);
    }
}