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
}
