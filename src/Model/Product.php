<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-06
 * Time: 13:22
 */

namespace SallePW\pwpop\Model;


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
    private $dateUpload;

    /**
     * @var int
     */
    private $price;

    /**
     * @var int
     */
    private $category;

    /**
     * Product constructor.
     * @param string $hashId
     * @param string $userId
     * @param string $description
     * @param string $dateUpload
     * @param int $price
     * @param int $category
     */
    public function __construct(
        string $hashId,
        string $userId,
        string $description,
        string $dateUpload,
        int $price,
        int $category
    ) {
        $this->hashId = $hashId;
        $this->userId = $userId;
        $this->description = $description;
        $this->dateUpload = $dateUpload;
        $this->price = $price;
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getHashId(): string
    {
        return $this->hashId;
    }

    /**
     * @param string $hashId
     */
    public function setHashId(string $hashId): void
    {
        $this->hashId = $hashId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDateUpload(): string
    {
        return $this->dateUpload;
    }

    /**
     * @param string $dateUpload
     */
    public function setDateUpload(string $dateUpload): void
    {
        $this->dateUpload = $dateUpload;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }



    /**
     * Product constructor.
     * @param string $title
     * @param string $description
     * @param int $price
     * @param array $product_image
     * @param int $category
     */


}
