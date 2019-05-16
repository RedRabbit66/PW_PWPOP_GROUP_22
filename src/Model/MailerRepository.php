<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-16
 * Time: 19:53
 */

namespace SallePW\pwpop\Model;


interface MailerRepository
{
    public function sendMail($username, $to, $message);
}