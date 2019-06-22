<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-18
 * Time: 10:34
 */

namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\ProductRepository;

class UpdateProductUseCase
{
    /** @var ProductRepository */
    private $repo;

    /**
     * PostUserUseCase constructor.
     * @param ProductRepository $repo
     */
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    public function __invoke(string $productId, string $title, string $description, string $price, string $category){

        $this->repo->updateProduct($productId, $title, $description, $price, $category);
    }
}