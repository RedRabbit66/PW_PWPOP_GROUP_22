<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-07
 * Time: 14:03
 */

namespace SallePW\pwpop\Controller;


interface Mailer
{
    public function sendMail($username, $to, $message);
}