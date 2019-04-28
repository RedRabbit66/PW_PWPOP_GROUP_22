<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-28
 * Time: 21:35
 */

namespace SallePW\pwpop\Model;

interface MailerRepository
{
    public function sendMail($username, $to, $message);
}