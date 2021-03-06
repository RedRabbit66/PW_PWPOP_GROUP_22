<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-18
 * Time: 19:10
 */
namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\ProductRepository;


class DeleteProductUseCase
{
    private $repo;

    public function __construct(ProductRepository $repo) {
        $this->repo = $repo;
    }

    public function __invoke($productId) {
        return $this->repo->deleteProduct($productId);
    }
}