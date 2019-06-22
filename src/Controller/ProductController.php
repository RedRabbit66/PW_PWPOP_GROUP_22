<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-14
 * Time: 20:03
 */

namespace SallePW\pwpop\Controller;

use PHPMailer\PHPMailer\Exception;
use Psr\Container\ContainerInterface;

use PHPMailer\PHPMailer\PHPMailer;

use SallePW\pwpop\Model\UseCase\SendMailUseCase;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProductController
{

    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }


    public function __invoke(Request $request, Response $response, array $args)
    {

        if (isset($args['productid'])) {
            $service = $this->container->get('get_product_repository');
            $product = $service($args['productid']);


                if ($product[0]['sold_out']) {
                    //No hay disponibles
                    $soldOut = 1;

                    $protocol = $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
                        || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
                    $url = $protocol . $_SERVER['SERVER_NAME'];

                    $url = $url . '/';
                    return $this->container->get('view')->render($response->withHeader('Location', $url), 'home.html.twig');


                } else {

                    session_start();

                    $protocol = $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
                        || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
                    $url = $protocol . $_SERVER['SERVER_NAME'];

                    if (empty($_SESSION['user_id'])){

                        $url = $url . '/';
                        //cambiar por /login
                        return $this->container->get('view')->render($response->withHeader('Location', $url), 'home.html.twig');

                    }else{

                        //Restar 1 en el stock ($soldOut = 1) en sql
                        $service = $this->container->get('set_product_soldout_repository');
                        $service($product[0]['id']);

                        $productPropietary = $product[0]['user_id'];

                        $service = $this->container->get('get_user_repository');
                        $vendor = $service($productPropietary);

                        $service = $this->container->get('search_user_repository');
                        $user = $service();

                        $buyerUsername = $user['username'];
                        $buyerEmail = $user['email'];
                        $buyerPhone = $user['phone_number'];

                        $message = "<html><head><title>Your product has been buyed</title></head><body>The buyer is " . $buyerUsername . "\n Get in contact with him with his email: " . $buyerEmail . " and his mobile phone: " . $buyerPhone . "</body></html>";

                        //Enviar mail
                        /*$service = $this->container->get('send_mail_service');
                        $service($username, $to, "<html><head><title>TITOL</title></head><body><h1>Hola</h1></body></html>");
                        */

                        $this->sendMail2( $vendor['email'], $message);

                        return $response->withStatus(200)->withHeader('Location', '/');

                    }

                }


        }
    }


    private function sendMail2(string $to, string $message){
        //Import PHPMailer classes into the global namespace

        require '../vendor/autoload.php';
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 2;
        //Set the hostname of the mail server
        $mail->Host = 'smtp.office365.com';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;
        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'starttls';
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "pwpop22@outlook.com";
        //Password to use for SMTP authentication
        $mail->Password = "PW-22-pwpop";
        //Set who the message is to be sent from
        $mail->setFrom('pwpop22@outlook.com', 'PWPop 22');
        //Set an alternative reply-to address
        $mail->addReplyTo('pwpop22@gmail.com', 'PWpop 22');
        //Set who the message is to be sent to
        $mail->addAddress($to);
        //Set the subject line
        $mail->Subject = 'Product Seld';
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($message);
        //Replace the plain text body with one created manually
        //$mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        //send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
            //Section 2: IMAP
            //Uncomment these to save your message in the 'Sent Mail' folder.
            #if (save_mail($mail)) {
            #    echo "Message saved!";
            #}
        }
    }

}