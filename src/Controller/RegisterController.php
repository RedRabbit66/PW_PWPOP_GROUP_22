<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 13/04/2019
 * Time: 11:42
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \Slim\Http\UploadedFile;
use \Psr\Http\Message\UploadedFileInterface;

class RegisterController
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

    public function __invoke(Request $request, Response $response) {
       // $error[] = $this->validateUser();

        if (0 != 0) {
            $status = 302;
        } else {

            try {
                $this -> uploadAction($request, $response);
                //Registramos al usuario
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
                        $errors['username'] = "Username field can only contain alphanumeric characters and should never exceed the 20 characters";
                    }
                } elseif($data == 'name') {
                    if (!preg_match("/^[A-Za-z0-9_-]+$/i", $val)) {
                        $errors['name'] = "Name field can only contain letters";
                    }
                } elseif($data == 'email') {
                    if (!preg_match("/^\S+@\S+\.\S+$/", $val)) {
                        $errors['email'] = "Email field must be a valid email address";
                    }
                } elseif ($data == 'birthday') {
                    $year = substr($val, 0, 4);

                    if($year < 1850 || $year > 2019){
                        $errors['birthday'] = "Birthday field must be a valid date";
                    }
                } elseif($data == 'phoneNumber') {
                    if (!is_numeric($val)) {
                        $errors['name'] = "In phone number field all numbers must follow the format nxx xxx xxx";
                    }
                } elseif ($data == 'password') {
                    $password = $val;

                    if (strlen($val) < 6) {
                        $errors['password'] = "Password must contain at least 6 characters";
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


    //ZONA COMPRUEBA + CARGA IMAGEN

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

            // We generate a custom name here instead of using the one coming form the form
            $uploadedFile->moveTo(self::UPLOADS_DIR . DIRECTORY_SEPARATOR . $_POST['username']. '_ImageProfile_' . $name);
        }

        return $this->container->get('view')->render($response, 'home.html.twig');
    }

    private function isValidFormat(string $extension): bool
    {
        return in_array($extension, self::ALLOWED_EXTENSIONS, true);
    }


}