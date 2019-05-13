<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 30/04/2019
 * Time: 12:56
 */

namespace SallePW\pwpop\Model\UseCase;

use SallePW\pwpop\Model\FileRepository;


class PostFolderUseCase
{
    private $repo;

    public function __construct(FileRepository $repo) {
        $this->repo = $repo;
    }

    public function __invoke($userId, $folderId, $folderName, $rootFolder) {
        return $this->repo->saveFolder($userId, $folderId, $folderName, $rootFolder);
    }
}