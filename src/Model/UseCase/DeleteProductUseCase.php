<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 30/04/2019
 * Time: 12:54
 */

namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\ProductRepository;


class DeleteProductUseCase
{
    private $repo;

    public function __construct(ProductRepository $repo) {
        $this->repo = $repo;
    }

    public function __invoke($userId, $fileId) {
        return $this->repo->deleteFile($userId, $fileId);
    }
}