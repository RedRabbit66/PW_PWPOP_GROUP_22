<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 30/04/2019
 * Time: 12:43
 */

namespace SallePW\pwpop\Model\Implementation;



    use \PDO;
    use \Hashids\Hashids;
    use \Doctrine\DBAL\Driver\Connection;
    use SallePW\pwpop\Model\File;
    use SallePW\pwpop\Model\Folder;
    use SallePW\pwpop\Model\ProductRepository;
    use SallePW\pwpop\Model\Product;

class DoctrineProductRepository implements ProductRepository {
    const DATE_FORMAT = 'Y-m-d';
    private $database;

    public function __construct(Connection $database) {
        $this->database = $database;
    }


    public function saveFile($userId, $folderId, $fileName, $fileSize, $fileExtension) {
        $folderPath = '';
        $error = false;

        $hashids = new Hashids((new \DateTime())->format('Y-m-d H:i:s') . $userId . $folderId . $fileName);
        $filePath = $hashids->encode(1, 2, 3);

            $folderPath = $this->getFolderPath($folderId);

            if (!$this->updateRemainingStorage($folderId, $fileSize)) {
                $error = true;
            } else {
                if (!$this->registerFile($fileName, $filePath, $folderId, $fileExtension)) {
                    $error = true;
                }
            }

        if ($error == true) {
            return '';
        }

        return $folderPath . '/' . $filePath . '.' . $fileExtension;
    }

    private function getUserIdByEmail($email) {
        $id = -1;

        $sql = 'SELECT id FROM users WHERE email LIKE :email';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('email', $email, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $id = $row['id'];
        }

        return $id;
    }

    private function getUserIdByHashId($userId) {
        $id = -1;

        $sql = 'SELECT id FROM users WHERE hash_id LIKE :hash_id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('hash_id', $userId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $id = $row['id'];
        }

        return $id;
    }

    public function getProducts() {
        $sql = 'SELECT * FROM products ORDER BY dateUpload DESC LIMIT 5';
        $stmt = $this->database->prepare($sql);
        //$stmt->bindValue('hash_id', $folderHashId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        /*$products = array();

        foreach($result as $row) {
            //$hashId = $row['hash_id'];
            $title = $row['file_name'];
            $path = $row['file_path'];
            $aux = new Product($title, 'default description', 2000, 'car.jpg', 1);
            $products[] = $aux;
        }*/

        return $result;
    }

    public function getProduct($productId) {
        $sql = 'SELECT * FROM products WHERE id LIKE :productId';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('productId', $productId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    public function uploadProduct($product){
        $product->generateHashId();
        //falta gestion image
        $user_hash_id = $_SESSION['user_id'];

        $user_id = $this->getUserIdByHashId($user_hash_id);

        $sql = 'INSERT INTO users(hash_id, user_id, description, price, category, title, product_image) 
                VALUES(:hash_id, :user_id, :description, :price, :category, :title, :product_image)';

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('hash_id', $product->getHashId(), 'string');
        $stmt->bindValue('name', $user_id, 'string');
        $stmt->bindValue('username', $product->getDescription(), 'string');
        $stmt->bindValue('birth_date', $product->getPrice(), 'string');
        $stmt->bindValue('phone_number', $product->getCategory(), 'string');
        $stmt->bindValue('password', $product->getTitle(), 'string');
        $stmt->bindValue('profile_image', 'photo', 'string');

        $stmt->execute();
    }
}