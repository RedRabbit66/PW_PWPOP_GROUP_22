<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-28
 * Time: 21:54
 */

namespace SallePW\pwpop\Model\Services;

use SallePW\pwpop\Model\UserRepository;

class CheckVerificationService
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * LoginUserService constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($key)
    {

        return $this->repository->checkVerification($key);
    }
}