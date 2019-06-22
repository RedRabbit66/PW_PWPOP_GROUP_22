<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 15/04/2019
 * Time: 17:24
 */

namespace SallePW\pwpop\Controller;

use \Psr\Container\ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\UploadedFileInterface;


class UpdateUserController
{
    protected $container;

    //ZONA CONSTANTES IMAGEN
    private const UPLOADS_DIR = __DIR__ . '/../../public/assets/images';

    private const UNEXPECTED_ERROR = "An unexpected error occurred uploading the file '%s'...";

    private const INVALID_EXTENSION_ERROR = "The received file extension '%s' is not valid";

    // We use this const to define the extensions that we are going to allow
    private const ALLOWED_EXTENSIONS = ['jpg', 'png'];

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response)
    {
        $errors = $this->validateUser();
        $statusMessage = "";

        if (0 != 0) {
            $status = 302;
            $statusMessage = "error";
        } else {
            try {
                $this -> uploadAction($request, $response);

                $data = $request->getParsedBody();
                $service = $this->container->get('update_user_repository');
                $service($data);
                $status = 200;
                $statusMessage = "success";
            } catch (\Exception $e) {
                $status = 302;
                $statusMessage = "error";
            }
        }
        $protocol = $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
            || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';

        $response = $response
            ->withStatus($status)
            ->withHeader('Location',
                $protocol . $_SERVER['SERVER_NAME'] . '/profile?action=update_user&status=' . $statusMessage);

        return $response;
    }

    public function validateUser(){
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = '';


            foreach ($_POST as $data => $val) {
                if ($data == 'name') {
                    if (strlen($val)==0){
                        $errors['name'] = "The name field is required";
                    }elseif (!preg_match("/^[A-Za-z0-9]+$/i", $val)) {
                        $errors['name'] = "Name field can only contain alphanumeric characters";
                    }
                } elseif($data == 'username') {
                    if (strlen($val)==0){
                        $errors['username'] = "The username field is required";
                    }else{
                        if (!preg_match("/^[A-Za-z0-9]+$/i", $val)) {
                            $errors['username'] = "Username field can only contain alphanumeric characters";
                        }
                        if (strlen($val)>20){
                            $errrors['username_1']="Username field must contain a maximum of 20 characters";
                        }
                    }
                } elseif($data == 'email') {
                    if (strlen($val)==0){
                        $errors['email'] = "Email field is required";
                    }elseif (!preg_match("/^\S+@\S+\.\S+$/", $val)) {
                        $errors['email'] = "Email field must contain a valid email address";
                    }
                } elseif ($data == 'birthday') {
                    if (strlen($val)!=0){
                        if (!$this->isValidDate($val)){
                            $errors['birthday']="Please, enter a valid date";
                        }
                    }
                } elseif($data == 'phoneNumber') {
                    if(strlen($val)==0){
                        $errors['phoneNumber']="Phone field is required";
                    }elseif(!is_numeric($val)) {
                        $errors['name'] = "Phone number should only contain digits";
                    }elseif(strlen($val)!=9){
                        $errors['name'] = "Phone field must follow XXXXXXXXX format";
                    }
                } elseif ($data == 'password') {
                    $password = $val;
                    if(strlen($val)==0){
                        $errors['password']="Password field is required";
                    }elseif (strlen($val) < 6 || strlen($val)>12) {
                        $errors['password'] = "Password must be 6 to 12 characters long";
                    }elseif(!preg_match("/^(?=(?:.*\d){1})(?=(?:.*[A-Z]){1})\S+$/", $val)){
                        $errors['password']="Password must at least contain one number and a capital letter.";
                    }
                } elseif ($data == 'confirmPassword') {
                    if (strlen($val) == 0) {
                        $errors['confirmPassword'] = "Confirm password field is required";
                    } elseif ($val != $password) {
                        $errors['confirmPassword'] = "Password mismatch";
                    }
                }
            }
            return $errors;
        }
        return -1;
    }


    public function uploadAction(Request $request, Response $response){
        $uploadedFiles = $request->getUploadedFiles();

        $errors = [];

        //var_dump($_FILES['files']['name'][0]);
        /** @var UploadedFileInterface $uploadedFile */
        foreach ($uploadedFiles['files'] as $uploadedFile) {
            if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
                $errors[] = sprintf(self::UNEXPECTED_ERROR, $uploadedFile->getClientFilename());
                continue;
            }

            $name = $uploadedFile->getClientFilename();

            $fileInfo = pathinfo($name);
            echo (self::UPLOADS_DIR . DIRECTORY_SEPARATOR . $name);

            $format = $fileInfo['extension'];

            if (!$this->isValidFormat($format)) {
                $errors[] = sprintf(self::INVALID_EXTENSION_ERROR, $format);
                continue;
            }

            $extension = '.' . explode(".", $_FILES['files']['name'][0])[1];

            // We generate a custom name here instead of using the one coming form the form
            $uploadedFile->moveTo(self::UPLOADS_DIR . DIRECTORY_SEPARATOR . 'ImageProfile_' . $_POST['username']. $extension);
        }

        return $this->container->get('view')->render($response, 'home.html.twig');
    }

    private function isValidFormat(string $extension): bool
    {
        return in_array($extension, self::ALLOWED_EXTENSIONS, true);
    }

    private function isValidDate(string $date){

        if(!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $date)){
            return false;
        }

        $monthLength = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

        $dateSplitted = explode("/", $date);

        $day = intval($dateSplitted[0]);
        $month = intval($dateSplitted[1]);
        $year = intval($dateSplitted[2]);

        if ($year < 1900 || $year > 2020 || $month == 0 || $month > 12) {
            return false;
        }elseif ($month < 0 || $month > 12){
            return false;
        }elseif ($year % 400 == 0 || ($year % 100 != 0 && $year % 4 == 0)){
            $monthLength[1] = 29;
        }elseif (($day > 0) && ($day <= $monthLength[$month - 1])){
            return false;
        }
        return true;
    }

}