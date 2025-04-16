<?php

namespace App\projection;
class ProductDetailQuantity
{
    public int|null $id;
    public string $title;
    public string $description;
    public int $price;
    public int $quantity;
    public string $imageUrl;

    /**
     * @param string $description
     * @param int|null $id
     * @param string $imageUrl
     * @param int $price
     * @param int $quantity
     * @param string $title
     */
    public function __construct(?int $id, string $title, string $description, string $imageUrl, int $price, int $quantity)
    {
        $this->description = $description;
        $this->id = $id;
        $this->imageUrl = $imageUrl;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
