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

        $sql = 'SELECT * FROM products ORDER BY dateUpload LIMIT 5';
        $stmt = $this->database->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getProducts2()
    {
        //echo$_SESSION['user_id'];
        /*if(isset($_SESSION['user_id'])) {
            $user_hash_id = $_SESSION['user_id'];
        }else{

            return -1;
        }

        $userId = $this->getUserIdByHashId($user_hash_id);*/

        $user_id = $_SESSION['user_id'];

        $sql = 'SELECT * FROM products WHERE user_id NOT LIKE :user_id ORDER BY dateUpload';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('user_id', $user_id, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getProducts3()
    {
        //echo$_SESSION['user_id'];
        if(isset($_SESSION['user_id'])) {
            $user_hash_id = $_SESSION['user_id'];
        }else{

            return -1;
        }

        $userId = $this->getUserIdByHashId($user_hash_id);

        $sql = 'SELECT * FROM products WHERE user_id NOT LIKE :user_id ORDER BY dateUpload LIMIT 5';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('user_id', $userId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

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

        $extension = '.' . explode(".", $_FILES['files']['name'][0])[1];
        $imageProfileName =  'ImageProduct_' . $product->getHashId() . $extension;
        session_start();
        $user_id = $_SESSION['user_id'];

        $sql = 'INSERT INTO products(hash_id, user_id, description, price, category, title, product_image) 
                VALUES(:hash_id, :user_id, :description, :price, :category, :title, :product_image)';

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('hash_id', $product->getHashId(), 'string');
        $stmt->bindValue('user_id', $user_id, 'string');
        $stmt->bindValue('description', $product->getDescription(), 'string');
        $stmt->bindValue('price', $product->getPrice(), 'string');
        $stmt->bindValue('category', $product->getCategory(), 'string');
        $stmt->bindValue('title', $product->getTitle(), 'string');
        $stmt->bindValue('product_image', $imageProfileName , 'string');

        $stmt->execute();
    }

    public function searchProduct($input)
    {
        $inputSearch1 = '%' . $input . '%';
        $inputSearch2 = $input . '%';
        $inputSearch3 = '%' . $input;
        $inputSearch4 = $input;

        $sql = 'SELECT * FROM products WHERE title LIKE 
                :inputSearch1 OR title LIKE :inputSearch2 OR title LIKE :inputSearch3 OR title LIKE :inputSearch4 ORDER BY dateUpload DESC LIMIT 5';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('inputSearch1', $inputSearch1, 'string');
        $stmt->bindValue('inputSearch2', $inputSearch2, 'string');
        $stmt->bindValue('inputSearch3', $inputSearch3, 'string');
        $stmt->bindValue('inputSearch4', $inputSearch4, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        if(empty($result)){
            $result = -1;
        }
        return $result;
    }

    public function updateProduct($productId, $title, $description, $price, $category){

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

        $user_id = $_SESSION['user_id'];
        /*
        $user_id = $this->getUserIdByHashId($userHashId);
        */
        $sql = 'SELECT * FROM products WHERE user_id LIKE :user_id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('user_id', $user_id, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();


        return $result;
    }

    public function deleteProduct($productId){
        $sql = 'DELETE FROM products WHERE id LIKE :id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('id', $productId, 'string');
        $stmt->execute();
    }


}