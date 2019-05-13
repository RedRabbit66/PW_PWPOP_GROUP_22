<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 30/04/2019
 * Time: 13:07
 */

namespace SallePW\pwpop\Model;


class File
{
    private $hashId;
    private $name;
    private $path;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getHashId() {
        return $this->hashId;
    }

    public function setHashId($hashId) {
        $this->hashId = $hashId;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }
}