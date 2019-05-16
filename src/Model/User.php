<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-06
 * Time: 13:11
 */
namespace SallePW\pwpop\Model;

use \Hashids\Hashids;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $hash_id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var String
     */
    private $birthdate;

    /**
     * @var int
     */
    private $phoneNumber;

    /**
     * @var string
     */
    private $password;


    public function __construct($name, $username, $email, $birthdate, $phoneNumber, $password) {
            $this->name = $name;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->phoneNumber = $phoneNumber;
            $this->birthdate = $birthdate;
        }

    public function generateHashId() {
        $hashids = new Hashids($this->username . $this->email);
        $this->hash_id = $hashids->encode(1, 2, 3);
    }

    /**
     * @return string
     */
    public function getEncryptedPassword() {
        return md5($this->password);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getHashId()
    {
        return $this->hash_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return String
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }
}
