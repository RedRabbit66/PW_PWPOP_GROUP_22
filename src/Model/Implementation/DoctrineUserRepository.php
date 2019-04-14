<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 13/04/2019
 * Time: 13:03
 */

namespace SallePW\pwpop\Model\Implementation;

use \Hashids\Hashids;
use \Doctrine\DBAL\Driver\Connection;
use SallePW\pwpop\Model\User;
use SallePW\pwpop\Model\UserRepository;

class DoctrineUserRepository implements UserRepository
{
    private $database;

    public function __construct(Connection $database)
    {
        $this->database = $database;
    }

    public function saveUser(User $user)
    {
        $user->generateHashId();
        $sql = 'INSERT INTO users(hash_id, name, username, email, birth_date, phone_number, password, profile_image) VALUES(:hash_id, :name, :username, :email, :birth_date, :phone_number, :password, :profile_image)';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('hash_id', $user->getHashId(), 'string');
        $stmt->bindValue('name', $user->getName(), 'string');
        $stmt->bindValue('username', $user->getUsername(), 'string');
        $stmt->bindValue('email', $user->getEmail(), 'string');
        $stmt->bindValue('birth_date', $user->getBirthdate(), 'string');
        $stmt->bindValue('phone_number', $user->getphoneNumber(), 'string');
        $stmt->bindValue('password', $user->getEncryptedPassword(), 'string');
        $stmt->bindValue('profile_image', $user->getprofileImage(), 'string');
        $stmt->execute();

/*
        echo($user->getHashId() . '!!!!!!!!!!');
        echo($user->getName(). '!!!!!!!!!!');
        echo($user->getUsername(). '!!!!!!!!!!');
        echo($user->getEmail(). '!!!!!!!!!!');
        echo($user->getBirthdate(). '!!!!!!!!!!');
        echo($user->getPhoneNumber(). '!!!!!!!!!!');
        echo($user->getEncryptedPassword(). '!!!!!!!!!!');
        echo($user->getProfileImage(). '!!!!!!!!!!');
*/

    }


    public function getUserId($email, $password) {
        $hashId = '-1';

        $sql = 'SELECT hash_id FROM users WHERE email LIKE :email OR username LIKE :email AND password LIKE :password';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('email', $email, 'string');
        $stmt->bindValue('password', $password, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $hashId = $row['hash_id'];
        }

        $data = array('user_id' => $hashId);

        return $data;
    }
}