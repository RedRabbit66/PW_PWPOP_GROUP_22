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
    private const UPLOADS_DIR = __DIR__ . '/../../uploads';

    private const UNEXPECTED_ERROR = "An unexpected error occurred uploading the file '%s'...";

    private const INVALID_EXTENSION_ERROR = "The received file extension '%s' is not valid";

    // We use this const to define the extensions that we are going to allow
    private const ALLOWED_EXTENSIONS = ['jpg', 'png'];

    protected $errors = [];

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

                //$this->sendMail($_POST['username'], $_POST['username'], "Link");

                //Envia email
                $verificationKey = md5($_POST['username'] . $_POST['email']);
                $message = 'Hello ' . $_POST['username'] . '<a href="http://pwpop.test/Activation_mail/' . $verificationKey . '"> Click here to verificate your account</a>';

                //Podem definir això:
                $sendMailService = $this->container->get('send_mail_service');
                $sendMailService($_POST['username'], $_POST['email'], $verificationKey, $message);

                //O cridar la funcio directament:
                $this->sendMail($_POST['username'], $_POST['email'], $message);

                $postVerificationKeyService = $this->container->get('post_verification_key_service');
                $postVerificationKeyService($verificationKey);

                $this->container->get('post_user_repository')->addMessage('user_register', 'The user has been succesfully registered');



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

    public function sendMail($username, $to, $message) {
        try {
            $this->mail->setFrom('pwpop22@outlook.com', 'NO-REPLY');
            $this->mail->addAddress($to, $username);

            $this->mail->isHTML(true);
            $this->mail->Subject = 'Pwpop Confirmation email';
            $this->mail->Body = $message;
            $this->mail->AltBody = $message;

            $this->mail->send();
        } catch (Exception $exeption) {
            echo 'Email has not been sent. Mailer Error: ', $this->mail->ErrorInfo;
        }
    }














    public function indexAction(Request $request, Response $response): Response
    {
        return $this->container->get('view')->render($response, 'register.html.twig', []);
    }

    public function uploadAction(Request $request, Response $response): Response
    {
        $uploadedFiles = $request->getUploadedFiles();

        /** @var UploadedFileInterface $uploadedFile */
        foreach ($uploadedFiles['files'] as $uploadedFile) {
            if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
                $errors[] = sprintf(self::UNEXPECTED_ERROR, $uploadedFile->getClientFilename());
                continue;
            }

            $name = $uploadedFile->getClientFilename();

            $fileInfo = pathinfo($name);

            $format = $fileInfo['extension'];

            if (!$this->isValidFormat($format)) {
                $errors[] = sprintf(self::INVALID_EXTENSION_ERROR, $format);
                continue;
            }

            // We generate a custom name here instead of using the one coming form the form
            $uploadedFile->moveTo(self::UPLOADS_DIR . DIRECTORY_SEPARATOR . $name);
        }

        return $this->container->get('view')->render($response, 'register.html.twig', [
            'errors' => $errors,
        ]);
    }

    private function isValidFormat(string $extension): bool
    {
        return in_array($extension, self::ALLOWED_EXTENSIONS, true);
    }






    public function validateUser(){


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

                }
            }
            return $errors;
        }
        //return -1;
    }
}