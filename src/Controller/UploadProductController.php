<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 15/05/2019
 * Time: 18:02
 */

namespace SallePW\pwpop\Controller;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\UploadedFileInterface;


class UploadProductController
{
    private $container;

    private const UPLOADS_DIR = __DIR__ . '/../../public/assets/images';

    private const UNEXPECTED_ERROR = "An unexpected error occurred uploading the file '%s'...";

    private const INVALID_EXTENSION_ERROR = "The received file extension '%s' is not valid";

    // We use this const to define the extensions that we are going to allow
    private const ALLOWED_EXTENSIONS = ['jpg', 'png'];


    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response){
        if (0!=0){
            $status = 302;
        }else{
            try {
                $this -> uploadAction($request, $response);
                //Upload del producto
                $data = $request->getParsedBody();
                $service = $this->container->get('post_product_repository');
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

    public function validateProductUpload(){
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($_POST as $data => $val) {

                if ($data == 'uploadProduct_Name') {
                    if (strlen($val) == 0) {
                        $errors['uploadProduct_Name'] = "Title field is required";
                    }
                } elseif ($data == 'uploadProduct_Description') {
                    if (strlen($val) == 0) {
                        $errors['uploadProduct_Description'] = "Product description field is required";
                    } elseif (strlen($val) < 20) {
                        $errors['uploadProduct_Description'] = "Product description field must be at least 20 characters long";
                    }
                } elseif ($data == 'uploadProduct_Category') {
                    if (strcmp($val, "empty") == 0) {
                        $errors['uploadProduct_Category'] = "You must choose a product category";
                    }
                } elseif ($data == 'uploadProduct_Price') {
                    if (($val < 0) || !preg_match("/^[0-9]+$/", $val)) {
                        $errors['uploadProduct_Price'] = "Price must be a valid integer positive value";
                    }
                }
            }
        }
        return $errors;
    }

    public function uploadAction(Request $request, Response $response){
        $uploadedFiles = $request->getUploadedFiles();

        $errors = [];

        //var_dump($_FILES['files']['name'][0]);
        /** @var UploadedFileInterface $uploadedFile */
//        var_dump($uploadedFiles['files']);
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
            $uploadedFile->moveTo(self::UPLOADS_DIR . DIRECTORY_SEPARATOR . 'ImageProduct_' .$_POST['uploadProduct_Name']. '_' . $name);
        }

       // return $this->container->get('view')->render($response, 'home.html.twig');
    }

    private function isValidFormat(string $extension): bool
    {
        return in_array($extension, self::ALLOWED_EXTENSIONS, true);
    }

}
