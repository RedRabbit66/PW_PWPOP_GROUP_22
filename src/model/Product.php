<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-06
 * Time: 13:22
 */

namespace SallePW\pwpop\model;


class Product
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $price;

    /**
     * @var array
     */
    private $product_image = array();

    /**
     * @var int
     */
    private $category;

    /**
     * Product constructor.
     * @param string $title
     * @param string $description
     * @param int $price
     * @param array $product_image
     * @param int $category
     */
    public function __construct(string $title, string $description, int $price, array $product_image, int $category)
    {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->product_image = $product_image;
        $this->category = $category;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return array
     */
    public function getProductImage(): array
    {
        return $this->product_image;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }



}
