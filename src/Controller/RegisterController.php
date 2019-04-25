<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 13/04/2019
 * Time: 11:42
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterController
{
    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response) {
       // $error[] = $this->validateUser();

        if (0 != 0) {
            $status = 302;
        } else {
            try {
                $data = $request->getParsedBody();
                $service = $this->container->get('post_user_repository');
                $service($data);

                $status = 200;
            } catch (\Exception $e) {
                $status = 302;
            }
        }

        $protocol = $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
            || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        $response = $response
            ->withStatus($status)
            ->withHeader('Location', $protocol . $_SERVER['SERVER_NAME'] . '/?status=' . $status);

        return $response;
    }

    public function validateUser(){
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $password = '';
            /*$username = $data['username'];
            $email = $data['email'];
            $birthdate = $data['birthdate'];
            $password = $data['password'];
            $confirmPassword = $data['confirmPassword'];*/

            foreach ($_POST as $data => $val) {

                if ($data == 'username') {
                    if (!preg_match("/^[A-Za-z0-9_-]+$/i", $val) || strlen($val) > 20) {
                        $errors['username'] = "t can only contain alphanumeric characters and should never exceed the 20 characters";
                    }
                } elseif($data == 'name') {
                    if (!preg_match("/^[A-Za-z0-9_-]+$/i", $val)) {
                        $errors['name'] = "It can only contain alphanumeric characters";
                    }
                } elseif($data == 'email') {
                    if (!preg_match("/^\S+@\S+\.\S+$/", $val)) {
                        $errors['email'] = "It must be a valid email address";
                    }
                } elseif ($data == 'birthday') {
                    $year = substr($val, 0, 4);

                    if($year < 1850 || $year > 2019){
                        $errors['birthday'] = "It must be a valid date";
                    }
                } elseif($data == 'phoneNumber') {
                    if (!is_numeric($val)) {
                        $errors['name'] = "All numbers must follow the format nxx xxx xxx";
                    }
                } elseif ($data == 'password') {
                    $password = $val;

                    if (strlen($val) < 6) {
                        $errors['password'] = "It must contain at least 6 characters";
                    }
                } elseif ($data == 'confirmPassword') {
                    if ($val != $password) {
                        $errors['confirmPassword'] = 5;
                    }

                    //https://phppot.com/php/php-image-upload-with-size-type-dimension-validation/
                } elseif ($data == 'image') {
                    $ext = pathinfo($val, PATHINFO_EXTENSION);
                    if ($ext !== 'png' || $ext !== 'jpg') {
                        $errors['image'] = "Bad extension";
                    }
                } elseif ($data == 'image') {
                    $ext = pathinfo($val, PATHINFO_EXTENSION);
                    if ($ext !== 'png' || $ext !== 'jpg') {
                        $errors['image'] = "Bad size";
                    }
                }
            }
            return $errors;
        }
        return $errors;
    }
}