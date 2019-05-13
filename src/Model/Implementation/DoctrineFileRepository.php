<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 30/04/2019
 * Time: 12:43
 */

namespace SallePW\pwpop\Model\Implementation;



    use \PDO;
    use \DateTime;
    use \Hashids\Hashids;
    use \Doctrine\DBAL\Driver\Connection;
    use SallePW\pwpop\Model\File;
    use SallePW\pwpop\Model\Folder;
    use SallePW\pwpop\Model\FileRepository;

class DoctrineFileRepository implements FileRepository {
    const DATE_FORMAT = 'Y-m-d';
    private $database;

    public function __construct(Connection $database) {
        $this->database = $database;
    }

    public function saveFolder($userHashId, $folderHashId, $folderName, $rootFolder) {


            $hashids = new Hashids($userHashId . $folderHashId . $folderName . (new \DateTime())->format('Y-m-d H:i:s'));
            $hashids = $hashids->encode(1, 2, 3);

            //$owner = $this->getFolderOwnerIdByHashId($folderId);
            $userId = $this->getUserIdByHashId($userHashId);

            //echo($hashids . "+++++++++++");
           //echo($userId . "+++++++++++");
           // echo($folderName . "+++++++++++");
            echo($rootFolder . "+++++++++++¿¿");

            $sql = 'INSERT INTO folders(hash_id, user_id, folder_name, root_folder) VALUES (:hash_id, :user_id, :folder_name, :root_folder)';
            $stmt = $this->database->prepare($sql);
            $stmt->bindValue('hash_id', $hashids, 'string');
            $stmt->bindValue('user_id', $userId, 'string');
            $stmt->bindValue('folder_name', $folderName, 'string');
            $stmt->bindValue('root_folder', $rootFolder, 'string');
            $stmt->execute();



            if($rootFolder == 0){

                //Si no es la carpeta principal, buscamos de que usuario tiene la carpeta principal para meterla dentro
                //Encontramos el id de la carpeta principal
                $folderId = $this->getFolderIdByHashId($userHashId);

                $sql = 'INSERT INTO subfolders(parent_folder, child_folder) VALUES (:folder_id, :folder_hash_id)';
                $stmt = $this->database->prepare($sql);
                $stmt->bindValue('folder_id', $folderId, 'string');
                $stmt->bindValue('folder_hash_id', $hashids, 'string');
                $stmt->execute();

                return true;
            }

        //return false;
    }

    public function getContentByFolder($userHashId, $folderHashId) {
        $folder = $this->getFolderByIdAndOwner($userHashId, $folderHashId);
        $subfolders = array();

        if ($folder->getHashId() == '-1') {
            $folder = $this->getSharedFolderById($userHashId, $folderHashId);
        }

        if ($folder->getHashId() != '-1') {
            $subfolders = $this->getSubfoldersByParentId($userHashId, $folderHashId);
            $files = $this->getFilesByFolder($folderHashId);

            $folder->setFolders($subfolders);
            $folder->setFiles($files);
        }

        return $folder;
    }

    private function getFolderByIdAndOwner($userHashId, $folderHashId) {
        $id = -1;
        $hashId = '-1';
        $name = '';
        $root = false;

        $sql = 'SELECT f.* FROM folders f, users u WHERE u.hash_id LIKE :user_hash_id AND u.id = f.user_id AND f.hash_id LIKE :folder_hash_id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('user_hash_id', $userHashId, 'string');
        $stmt->bindValue('folder_hash_id', $folderHashId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $id = $row['user_id'];
            $hashId = $row['hash_id'];
            $name = $row['folder_name'];
            $root = $row['root_folder'];
        }

        $folder = new Folder($hashId, $name);
        $folder->setRootFolder($root);

        $sql = 'SELECT hash_id FROM users WHERE id = ' . $id;
        $stmt = $this->database->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $hashId = $row['hash_id'];
        }

        $folder->setPath($hashId);

        return $folder;
    }

    private function getSubfoldersByParentId($userHashId, $folderHashId) {
        $id = -1;
        $subfolders = array();
        $folderOwner = $this->getFolderOwnerIdByHashId($folderHashId);

        $sql = 'SELECT id FROM users WHERE hash_id LIKE :hash_id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('hash_id', $userHashId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $id = $row['id'];
        }

        $folderId = $this->getFolderIdByHashId($folderHashId);
        $sql = 'SELECT f.* FROM folders f, subfolders s WHERE s.parent_folder = ' . $folderId . ' AND s.child_folder = f.id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('folder_hash_id', $folderHashId, 'string');
        //$stmt->bindValue('user_hash_id', $userHashId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $hashId = $row['hash_id'];
            $name = $row['folder_name'];

            $subfolders[] = new Folder($hashId, $name);
        }

        return $subfolders;
    }

    private function getFilesByFolder($folderHashId) {
        $sql = 'SELECT fi.* FROM files fi, folders fo WHERE fo.hash_id LIKE :hash_id AND fo.id = fi.folder_id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('hash_id', $folderHashId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        $files = array();

        foreach($result as $row) {
            $hashId = $row['hash_id'];
            $name = $row['file_name'];
            $path = $row['file_path'];
            $aux = new File($name);
            $aux->setHashId($hashId);
            $aux->setPath($path);
            $files[] = $aux;
        }

        return $files;
    }

    private function getSharedFolderById($userHashId, $folderHashId) {
        $hashId = '-1';
        $name = '';
        $admin = false;

        $sql = 'SELECT f.hash_id, f.folder_name, s.admin FROM folders f, users u, shared s WHERE f.hash_id LIKE :folder_hash_id AND f.id = s.folder_id AND s.user_id = u.id AND u.hash_id LIKE :user_hash_id';
        //$sql = 'SELECT f.*, s.* FROM folders f, users u, shared s WHERE f.hash_id LIKE :folder_hash_id AND f.id = s.folder_id AND s.user_id LIKE :user_hash_id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('folder_hash_id', $folderHashId, 'string');
        $stmt->bindValue('user_hash_id', $userHashId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $hashId = $row['hash_id'];
            $name = $row['folder_name'];
            $admin = $row['admin'];
        }

        $folder = new Folder($hashId, $name);
        $folder->setAdminRole($admin);
        $folder->setGuest(true);
        $folderPath = '';

        if ($hashId != '-1') {
            $folderPath = $this->getFolderPath($folderHashId);
        }

        $folder->setPath($folderPath);

        return $folder;
    }

    public function saveFile($userId, $folderId, $fileName, $fileSize, $fileExtension) {
        $folderPath = '';
        $error = false;

        $hashids = new Hashids((new \DateTime())->format('Y-m-d H:i:s') . $userId . $folderId . $fileName);
        $filePath = $hashids->encode(1, 2, 3);

            $folderPath = $this->getFolderPath($folderId);

            if (!$this->updateRemainingStorage($folderId, $fileSize)) {
                $error = true;
            } else {
                if (!$this->registerFile($fileName, $filePath, $folderId, $fileExtension)) {
                    $error = true;
                }
            }

        if ($error == true) {
            return '';
        }

        return $folderPath . '/' . $filePath . '.' . $fileExtension;
    }

    private function getFolderPath($folderId) {
        $folderPath = '';

        $sql = 'SELECT u.* FROM folders f, users u WHERE f.hash_id LIKE :folder_id AND f.user_id = u.id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('folder_id', $folderId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $folderPath = $row['folder_path'];
        }

        return $folderPath;
    }

    private function updateRemainingStorage($folderId, $fileSize) {
        $id = -1;
        $remainingStorage = 0;

        $sql = 'SELECT u.* FROM folders f, users u WHERE f.hash_id LIKE :folder_id AND f.user_id = u.id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('folder_id', $folderId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $id = $row['id'];
            $remainingStorage = $row['remaining_storage'];
        }

        if ($fileSize <= $remainingStorage) {
            $remainingStorage = $remainingStorage - $fileSize;

            $sql = 'UPDATE users SET remaining_storage = ' . $remainingStorage . ' WHERE id = ' . $id;
            $stmt = $this->database->prepare($sql);
            $stmt->execute();

            return true;
        }

        return false;
    }

    private function registerFile($fileName, $filePath, $folderId, $fileExtension) {
        $id = -1;
        $flag = false;

        $sql = 'SELECT id FROM folders WHERE hash_id LIKE :folder_id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('folder_id', $folderId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $id = $row['id'];
        }

        if ($id != -1) {
            $sql = 'INSERT INTO files(hash_id, folder_id, file_name, file_path) VALUES(:hash_id, ' . $id . ', :file_name, :file_path)';
            $stmt = $this->database->prepare($sql);
            $stmt->bindValue('hash_id', $filePath, 'string');
            $stmt->bindValue('file_name', $fileName, 'string');
            $stmt->bindValue('file_path', $filePath . '.' . $fileExtension, 'string');
            $stmt->execute();
            $flag = true;
        }

        return $flag;
    }

    public function deleteFile($userId, $fileId) {
        if ($this->checkFilePermissions($userId, $fileId)) {
            $sql = 'DELETE FROM files WHERE hash_id LIKE :file_id';
            $stmt = $this->database->prepare($sql);
            $stmt->bindValue('file_id', $fileId, 'string');
            $stmt->execute();

            return true;
        } else {
            return false;
        }
    }

    public function changeFileName($userId, $fileId, $filename) {
        if ($this->checkFilePermissions($userId, $fileId)) {
            $sql = 'UPDATE files SET file_name = :file_name WHERE hash_id LIKE :file_id';
            $stmt = $this->database->prepare($sql);
            $stmt->bindValue('file_name', $filename, 'string');
            $stmt->bindValue('file_id', $fileId, 'string');
            $stmt->execute();

            return true;
        } else {
            return false;
        }
    }

    private function checkFilePermissions($userId, $fileId) {
        $id = -1;

        $sql = 'SELECT u.* FROM folders f, files fi, users u WHERE fi.hash_id LIKE :file_id AND fi.folder_id = f.id AND f.user_id = u.id AND u.hash_id LIKE :user_id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('file_id', $fileId, 'string');
        $stmt->bindValue('user_id', $userId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $id = $row['id'];
        }

        if ($id == -1) {
            $admin = false;

            $sql = 'SELECT s.admin FROM shared s, files fi, folders fo, users u WHERE fi.hash_id LIKE :file_id AND u.hash_id AND fi.folder_id = fo.id AND fo.id = s.folder_id AND u.hash_id LIKE :user_id AND u.id = s.user_id';
            $stmt = $this->database->prepare($sql);
            $stmt->bindValue('file_id', $fileId, 'string');
            $stmt->bindValue('user_id', $userId, 'string');
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach($result as $row) {
                $admin = $row['admin'];
            }

            return $admin;
        } else {
            return true;
        }
    }

    private function getFolderOwnerIdByHashId($folderId) {
        $id = -1;

        $sql = 'SELECT u.id FROM users u, folders f WHERE f.hash_id LIKE :folder_id AND f.user_id = u.id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('folder_id', $folderId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $id = $row['id'];
        }

        return $id;
    }

    private function getFolderIdByHashId($folderId) {
        $id = -1;

        $sql = 'SELECT id FROM folders WHERE hash_id LIKE :folder_id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('folder_id', $folderId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $id = $row['id'];
        }

        return $id;
    }

    public function deleteFolder($userId, $folderId) {
            $id = $this->getFolderIdByHashId($folderId);

            $sql = 'DELETE FROM shared WHERE folder_id = ' . $id;
            $stmt = $this->database->prepare($sql);
            $stmt->execute();

            $sql = 'DELETE FROM files WHERE folder_id = ' . $id;
            $stmt = $this->database->prepare($sql);
            $stmt->execute();

            $sql = 'DELETE FROM subfolders WHERE parent_folder = ' . $id . ' OR child_folder = ' . $id;
            $stmt = $this->database->prepare($sql);
            $stmt->execute();

            $sql = 'DELETE FROM folders WHERE id = ' . $id;
            $stmt = $this->database->prepare($sql);
            $stmt->execute();

    }

    public function renameFolder($userId, $folderId, $folderName) {
            $sql = 'UPDATE folders SET folder_name = :folder_name WHERE hash_id LIKE :hash_id';
            $stmt = $this->database->prepare($sql);
            $stmt->bindValue('folder_name', $folderName, 'string');
            $stmt->bindValue('hash_id', $folderId, 'string');
            $stmt->execute();

            return true;

        return false;
    }

    private function getUserIdByEmail($email) {
        $id = -1;

        $sql = 'SELECT id FROM users WHERE email LIKE :email';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('email', $email, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $id = $row['id'];
        }

        return $id;
    }

    private function getUserIdByHashId($userId) {
        $id = -1;

        $sql = 'SELECT id FROM users WHERE hash_id LIKE :hash_id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('hash_id', $userId, 'string');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            $id = $row['id'];
        }

        return $id;
    }

}