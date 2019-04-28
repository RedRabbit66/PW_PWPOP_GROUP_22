<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-28
 * Time: 21:57
 */

namespace SallePW\pwpop\Model\Services;

use SallePW\pwpop\Model\UserRepository;

class UpdateVerifiedService
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * UpdateVerifiedService constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($userId)
    {
        $this->repository->updateVerified($userId);
    }
}