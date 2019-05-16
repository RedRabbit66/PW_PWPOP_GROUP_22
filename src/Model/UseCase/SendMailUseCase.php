<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-28
 * Time: 21:33
 */

namespace SallePW\pwpop\Model\UseCase;


use SallePW\pwpop\Model\MailerRepository;
use SallePW\pwpop\Model\UserRepository;

class SendMailUseCase
{
    /**
     * @var MailerRepository
     */
    private $repository;

    /**
     * SendMailUseCase constructor.
     * @param MailerRepository $repository
     */
    public function __construct(MailerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($username, $to, $message)
    {
        $this->repository->sendMail($username, $to, $message);
    }
}