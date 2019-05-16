<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-06
 * Time: 13:22
 */

namespace SallePW\pwpop\Model;
use \Hashids\Hashids;

class Product
{
    /**
     * @var string
     */
    private $hashId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $category;

    public function __construct(
        string $title,
        string $description,
        string $price,
        string $category
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
    }

    public function generateHashId(){

        $hashId = new Hashids($this->title . $this->description);
        $this->hashId = $hashId->encode(1, 2, 3);
    }

    /**
     * @return string
     */
    public function getHashId(): string
    {
        return $this->hashId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

}