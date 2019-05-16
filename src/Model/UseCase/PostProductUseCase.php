<?php
/**
 * Created by PhpStorm.
 * User: alex_
 * Date: 16/05/2019
 * Time: 17:27
 */

namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\Product;
use SallePW\pwpop\Model\ProductRepository;

class PostProductUseCase{

    private $repo;

    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    public function __invoke(array $rawData){

        $product = new Product(
            $rawData['uploadProduct_Name'],
            $rawData['uploadProduct_Description'],
            $rawData['uploadProduct_Price'],
            $rawData['uploadProduct_Category']
        );
        $this->repo->uploadProduct($product);
    }
}