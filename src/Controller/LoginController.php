<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 13/04/2019
 * Time: 11:41
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class LoginController
{

    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response) {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        $errors = $this->validateUser();
        $id = '0';

       if(sizeof($errors) != 0){
            $id = -1;
        } else {
            try {
                $data = $request->getParsedBody();
                $service = $this->container->get('check_user_repository');
                $data = $service($data);

                $id = $data['user_id'];
                session_start();

            } catch (\Exception $e) {
                $id = '-1';
            }
        }

        $protocol = $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
            || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['SERVER_NAME'];

        if ($id == '-1') {
            $status = 302;
            $url = $url . '/login' . '?action=login_user&status=error';

        } else {
            $_SESSION['user_id'] = $id;
            $url = $url . '/'; //. '?action=login_user&status=success';
            $status = 200;
        }

        $response = $response
            ->withStatus($status)
            ->withHeader('Location', $url);

        return $response;
    }


    public function validateUser(){
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            foreach ($_POST as $data => $val) {
                if($data == 'usernameLogin') {
                    if (strlen($val)==0){
                        $errors['usernameLogin']="Username/login field is required";
                    }else{
                        if (!strpos($val, '@')){
                            if (!preg_match("/^[A-Za-z]+$/i", $val)){
                                $errors['usernameLogin_1']="Username must only contain alphanumeric characters";
                            }
                            if (strlen($val)>10){
                                $errors['UsernameLogin_1_1']="Username must contain a maximum of 10 characters";
                            }
                        }elseif (!preg_match("/^\S+@\S+\.\S+$/", $val)){
                            $errors['usernameLogin_1']="Must input a valid email address as username";
                        }
                    }
                } elseif ($data == 'password') {
                    if (strlen($val)==0){
                        $errors['password']="Password field is required";
                    }else{
                        if (strlen($val) < 6 || strlen($val) > 12) {
                            $errors['password'] = "Password must be 6 to 12 characters long";
                        }
                    }
                }
            }

            return $errors;
        }

        return -1;
    }
}