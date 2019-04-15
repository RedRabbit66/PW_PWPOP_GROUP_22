<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 14/04/2019
 * Time: 15:46
 */

namespace SallePW\pwpop\Model;


Interface UserRepository
{
    public function saveUser(User $user);
    public function getUserId($email, $password);
    public function searchUser();
    public function updateUser();
    public function deleteUser();
}