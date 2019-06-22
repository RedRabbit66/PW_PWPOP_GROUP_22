<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-18
 * Time: 10:04
 */

namespace SallePW\pwpop\Controller;

use Psr\Container\ContainerInterface;
use \Psr\Http\Message\UploadedFileInterface;
use \Hashids\Hashids;


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateProductController
{
    private $container;

    //ZONA CONSTANTES IMAGEN
    private const UPLOADS_DIR = __DIR__ . '/../../public/assets/images';

    private const UNEXPECTED_ERROR = "An unexpected error occurred uploading the file '%s'...";

    private const INVALID_EXTENSION_ERROR = "The received file extension '%s' is not valid";

    // We use this const to define the extensions that we are going to allow
    private const ALLOWED_EXTENSIONS = ['jpg', 'png'];


    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }


    public function __invoke(Request $request, Response $response, array $args)
    {

        if (isset($args['productid'])) {
            $this -> uploadAction($request, $response, $args);

            $data = $request->getParsedBody();
            $service = $this->container->get('update_product_repository');
            $service($args['productid'], $data['uploadProduct_Name'], $data['uploadProduct_Description'], $data['uploadProduct_Price'], $data['uploadProduct_Category']);

        } else {
            echo("No product, don't edit url!!!");
            //Error, no product
        }
        return $response->withStatus(200)->withHeader('Location', '/');
    }


    public function uploadAction(Request $request, Response $response, array $args){
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

            $service = $this->container->get('get_product_repository');
            $product = $service($args['productid']);
            // We generate a custom name here instead of using the one coming form the form
            $uploadedFile->moveTo(self::UPLOADS_DIR . DIRECTORY_SEPARATOR . $product[0]['product_image']);
        }


        return $this->container->get('view')->render($response, 'home.html.twig');
    }

    private function isValidFormat(string $extension): bool
    {
        return in_array($extension, self::ALLOWED_EXTENSIONS, true);
    }
}