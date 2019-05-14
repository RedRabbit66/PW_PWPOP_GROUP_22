<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 30/04/2019
 * Time: 13:08
 */

namespace SallePW\pwpop\Model;


interface FileRepository{
    public function getContentByFolder($userHashId, $folderHashId);
    public function saveFile($userId, $folderId, $fileName, $fileSize, $fileExtension);
    public function deleteFile($userId, $fileId);
    public function changeFileName($userId, $fileId, $filename);
    public function saveFolder($userId, $folderId, $folderName, $rootFolder);
    public function deleteFolder($userId, $folderId);
    public function renameFolder($userId, $folderId, $folderName);
    public function getProducts();
    public function getProduct($productId);
}
