<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 07/06/2019
 * Time: 13:19
 */

namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\UserRepository;


class GetImageProfileUseCase
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

    public function __invoke(){

        return $this->repo->getImageProfileUser();
    }
}