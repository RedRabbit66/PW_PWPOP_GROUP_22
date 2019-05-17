<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 17/05/2019
 * Time: 16:27
 */

namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\ProductRepository;


class SearchProductUseCase
{
    private $repo;

    public function __construct(ProductRepository $repo) {
        $this->repo = $repo;
    }

    public function __invoke($input) {
        return $this->repo->searchProduct($input);
    }

}