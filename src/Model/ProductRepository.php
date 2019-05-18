<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 30/04/2019
 * Time: 13:08
 */

namespace SallePW\pwpop\Model;


interface ProductRepository{
    public function getProducts();
    public function getProduct($productId);
    public function setProductSoldOut($productId);
    public function uploadProduct(Product $product);
    public function searchProduct($input);
    public function upgradeProduct($productId, $title, $description, $price, $category);
    public function getMyProducts($user_id);
    public function deleteProduct($productId);
}
