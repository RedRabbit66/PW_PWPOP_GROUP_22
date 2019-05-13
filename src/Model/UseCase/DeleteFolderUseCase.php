<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 30/04/2019
 * Time: 12:56
 */

namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\FileRepository;


class DeleteFolderUseCase
{
    private $repo;

    public function __construct(FileRepository $repo) {
        $this->repo = $repo;
    }

    public function __invoke($userId, $folderId) {
        return $this->repo->deleteFolder($userId, $folderId);
    }
}