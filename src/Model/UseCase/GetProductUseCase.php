<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-05-14
 * Time: 20:14
 */

namespace SallePW\pwpop\Model\UseCase;


class GetProductUseCase
{
    private $repo;

    public function __construct(FileRepository $repo) {
        $this->repo = $repo;
    }

    public function __invoke($productId) {
        return $this->repo->getProduct($productId);
    }
}