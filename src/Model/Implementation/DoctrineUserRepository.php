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
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use \DateTime;


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

        $extension = '.' . explode(".", $_FILES['files']['name'][0])[1];
        $imageProfileName =  'ImageProfile_' . $user->getUsername() . $extension;

        $sql = 'INSERT INTO users(hash_id, name, username, email, birth_date, phone_number, password, profile_image) VALUES(:hash_id, :name, :username, :email, :birth_date, :phone_number, :password, :profile_image)';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('hash_id', $user->getHashId(), 'string');
        $stmt->bindValue('name', $user->getName(), 'string');
        $stmt->bindValue('username', $user->getUsername(), 'string');
        $stmt->bindValue('email', $user->getEmail(), 'string');
        $stmt->bindValue('birth_date', $user->getBirthdate(), 'string');
        $stmt->bindValue('phone_number', $user->getphoneNumber(), 'string');
        $stmt->bindValue('password', $user->getEncryptedPassword(), 'string');
        $stmt->bindValue('profile_image', $imageProfileName, 'string');
        $stmt->execute();
    }


    public function getUserId($email, $password) {
        $hashId = '-1';

        $sql = 'SELECT hash_id FROM users WHERE (email LIKE :email OR username LIKE :email) AND password LIKE :password AND is_active LIKE :is_active';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('email', $email, 'string');
        $stmt->bindValue('password', $password, 'string');
        $stmt->bindValue('is_active', '1', 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach($result as $row) {
            $hashId = $row['hash_id'];
        }

        $data = array('user_id' => $hashId);

        return $data;
    }

    public function searchUser(){

        session_start();
        $hash_id = $_SESSION['user_id'];

        if($hash_id != -1){
            $sql = 'SELECT name, username, email, birth_date, phone_number FROM users WHERE hash_id LIKE :hash_id';
            $stmt = $this->database->prepare($sql);
            $stmt->bindValue('hash_id', $hash_id, 'string');
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach($result as $row) {
                $name = $row['name'];
                $username = $row['username'];
                $email = $row['email'];
                $birthday = $row['birth_date'];
                $phone_number = $row['phone_number'];
            }

            $data = array('name' => $name, 'username' => $username,  'email' => $email, 'birthday' => $birthday, 'phone_number' => $phone_number);
            return $data;
        }
        return -1;
    }

    public function updateUser(){
        session_start();
        $id = $_SESSION['user_id'];

        if($id != -1){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $birthday = $_POST['birthday'];
            $phone_number = $_POST['phone_number'];
            $password = md5($_POST['password']);

            $sql = 'UPDATE users SET name = :name, email = :email, birth_date = :birth_date, phone_number =:phone_number, password = :password WHERE hash_id LIKE :hash_id';
            $stmt = $this->database->prepare($sql);
            $stmt->bindValue('name', $name, 'string');
            $stmt->bindValue('email', $email, 'string');
            $stmt->bindValue('birth_date', $birthday, 'string');
            $stmt->bindValue('phone_number', $phone_number, 'string');
            $stmt->bindValue('password', $password, 'string');
            $stmt->bindValue('hash_id', $id, 'string');
            $stmt->execute();
        }
    }

    public function getImageProfileUser(){
        //session_start();
        $hash_id = $_SESSION['user_id'];

        if($hash_id != -1) {
            $sql = 'SELECT profile_image FROM users WHERE hash_id LIKE :hash_id';
            $stmt = $this->database->prepare($sql);
            $stmt->bindValue('hash_id', $hash_id, 'string');
            $stmt->execute();
            $result = $stmt->fetchAll();
            $imageProfile = $result[0]['profile_image'];
var_dump($imageProfile);
            //            return $result[0]['profile_image'];
        }
        return 1;

    }


    public function deleteUser(){
        session_start();

        $hash_id = $_SESSION['user_id'];

        if($hash_id != -1){

            //buscamos el id del usuario
            $sql = 'SELECT id FROM users WHERE hash_id LIKE :hash_id';
            $stmt = $this->database->prepare($sql);
            $stmt->bindValue('hash_id', $hash_id, 'string');
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach($result as $row) {
                $user_id = $row['id'];
            }

            //Ponemos a 0 el is_active del usuario
            $sql = 'UPDATE users SET is_active = 0 WHERE id LIKE :user_id';
            $stmt = $this->database->prepare($sql);
            $stmt->bindValue('user_id', $user_id, 'string');
            $stmt->execute();


            //Ponemos a 0 el is_active de los products del usuario
            //DELETE FROM products WHERE id LIKE :id
            $sql = 'DELETE FROM products WHERE user_id LIKE :user_id';
            $stmt = $this->database->prepare($sql);
            $stmt->bindValue('user_id', $hash_id, 'string');
            $stmt->execute();

            //Reedirigimos a la landing page y cerramos la session
            session_destroy();
        }
    }

    public function insertVerificationKey($userId, $key) {
        $sql = "INSERT INTO verification_key(user_id, verification_key) VALUES(?user_id, ?verification_key)";
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue("user_id", $userId, 'integer');
        $stmt->bindValue("verification_key", $key, 'string');
        $stmt->execute();
    }

    public function checkVerification($key) {
        $sql = "SELECT COUNT(*) AS count, user_id FROM verification_key WHERE verification_key = ?verification_key GROUP BY user_id";
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue("verification_key", $key, 'string');
        $stmt->execute();

        $verification = $stmt->fetch();

        if ($verification['count'] == 0){
            return FALSE;
        }

        return $verification['user_id'];
    }

    public function updateVerified($userId)
    {
        $sql = "UPDATE user SET verified = 1 WHERE id = ?user_id";
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue("user_id", $userId, 'integer');
        $stmt->execute();
    }

    public function sendMail($username, $to, $message) {
        try {
            $this->mail->setFrom('pwpop22@outlook.com', 'NO-REPLY');
            $this->mail->addAddress($to, $username);

            $this->mail->isHTML(true);
            $this->mail->Subject = 'Pwpop Buy Product';
            $this->mail->Body = $message;
            $this->mail->AltBody = $message;

            $this->mail->send();
        } catch (Exception $exeption) {
            echo 'Email has not been sent. Mailer Error: ', $this->mail->ErrorInfo;

        }

    }

    public function getUser($id){
        $sql = 'SELECT name, username, email, birth_date, phone_number FROM users WHERE hash_id LIKE :id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('id', $id, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $name = $row['name'];
            $username = $row['username'];
            $email = $row['email'];
            $birthday = $row['birth_date'];
            $phone_number = $row['phone_number'];
        }

        $data = array('name' => $name, 'username' => $username,  'email' => $email, 'birthday' => $birthday, 'phone_number' => $phone_number);
        return $data;
    }


}