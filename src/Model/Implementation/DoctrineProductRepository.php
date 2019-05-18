<?php
/**
 * Created by PhpStorm.
 * User: alex_
 * Date: 16/05/2019
 * Time: 17:27
 */

namespace SallePW\pwpop\Model\Implementation;



    use \PDO;
    use \Hashids\Hashids;
    use \Doctrine\DBAL\Driver\Connection;
    use SallePW\pwpop\Model\ProductRepository;
    use SallePW\pwpop\Model\Product;

class DoctrineProductRepository implements ProductRepository
{
    const DATE_FORMAT = 'Y-m-d';
    private $database;

    public function __construct(Connection $database)
    {
        $this->database = $database;
    }


    private function getUserIdByEmail($email)
    {
        $id = -1;

        $sql = 'SELECT id FROM users WHERE email LIKE :email';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('email', $email, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $id = $row['id'];
        }

        return $id;
    }

    private function getUserIdByHashId($userId)
    {
        $id = -1;

        $sql = 'SELECT id FROM users WHERE hash_id LIKE :hash_id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('hash_id', $userId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $id = $row['id'];
        }

        return $id;
    }

    public function getProducts()
    {
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

    public function getProduct($productId)
    {
        $sql = 'SELECT * FROM products WHERE id LIKE :productId';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('productId', $productId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    public function setProductSoldOut($productId)
    {
        $sql = 'UPDATE products SET sold_out = :sold_out WHERE id LIKE :productId';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('sold_out', 1, 'string');
        $stmt->bindValue('productId', $productId, 'string');
        $stmt->execute();

    }

    public function uploadProduct(Product $product)
    {
        $product->generateHashId();
        //falta gestion image
        session_start();
        $user_hash_id = $_SESSION['user_id'];

        $user_id = $this->getUserIdByHashId($user_hash_id);

        //echo($user_id);

        //$user_id = $_SESSION['user_id'];

        $sql = 'INSERT INTO products(hash_id, user_id, description, price, category, title, product_image) 
                VALUES(:hash_id, :user_id, :description, :price, :category, :title, :product_image)';

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('hash_id', $product->getHashId(), 'string');
        $stmt->bindValue('user_id', $user_id, 'string');
        $stmt->bindValue('description', $product->getDescription(), 'string');
        $stmt->bindValue('price', $product->getPrice(), 'string');
        $stmt->bindValue('category', $product->getCategory(), 'string');
        $stmt->bindValue('title', $product->getTitle(), 'string');
        $stmt->bindValue('product_image', 'photo', 'string');

        echo($product->getHashId());
        echo($user_id);
        echo($product->getDescription());
        echo($product->getPrice());
        echo($product->getCategory());
        echo($product->getTitle());

        $stmt->execute();
    }

    public function searchProduct($input)
    {
        $inputSearch1 = '%' . $input . '%';
        $inputSearch2 = $input . '%';
        $inputSearch3 = '%' . $input;

        $sql = 'SELECT * FROM products WHERE title LIKE 
                :inputSearch1 OR title LIKE :inputSearch2 OR title LIKE :inputSearch3 ORDER BY dateUpload DESC LIMIT 5';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('inputSearch1', $inputSearch1, 'string');
        $stmt->bindValue('inputSearch2', $inputSearch2, 'string');
        $stmt->bindValue('inputSearch3', $inputSearch3, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        if(empty($result)){
            $result = -1;
        }
        return $result;
    }

    public function upgradeProduct($productId, $title, $description, $price, $category){

            $sql = 'UPDATE products SET title = :title, price = :price, description = :description, category =:category WHERE id LIKE :id';
            $stmt = $this->database->prepare($sql);
            $stmt->bindValue('title', $title, 'string');
            $stmt->bindValue('price', $price, 'string');
            $stmt->bindValue('description', $description, 'string');
            $stmt->bindValue('category', $category, 'string');
            $stmt->bindValue('id', $productId, 'string');
            $stmt->execute();

    }

    public function getMyProducts(){

        $userHashId = $_SESSION['user_id'];

        $user_id = $this->getUserIdByHashId($userHashId);

        $sql = 'SELECT * FROM products WHERE user_id LIKE :user_id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('user_id', $user_id, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();


        return $result;
    }

    public function deleteProduct($productId){
        $sql = 'UPDATE products SET is_active = :is_active WHERE id LIKE :productId';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('is_active', 1, 'string');
        $stmt->bindValue('productId', $productId, 'string');
        $stmt->execute();
    }


}