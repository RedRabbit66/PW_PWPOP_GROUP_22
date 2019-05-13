<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 30/04/2019
 * Time: 12:55
 */

namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\FileRepository;

class UpdateFileUseCase
{
    private $repo;

    public function __construct(FileRepository $repo) {
        $this->repo = $repo;
    }

    public function __invoke($userId, $fileId, $filename) {
        return $this->repo->changeFileName($userId, $fileId, $filename);
    }
}