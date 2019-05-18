<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-18
 * Time: 12:00
 */

namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\ProductRepository;

class GetMyProductsUseCase
{
    private $repo;

    public function __construct(ProductRepository $repo) {
        $this->repo = $repo;
    }

    public function __invoke() {
        return $this->repo->getMyProducts();
    }
}