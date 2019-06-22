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
    public function getProducts2();
    public function getProduct($productId);
    public function setProductSoldOut($productId);
    public function uploadProduct(Product $product);
    public function searchProduct($input);
    public function updateProduct($productId, $title, $description, $price, $category);
    public function getMyProducts();
    public function deleteProduct($productId);
}
