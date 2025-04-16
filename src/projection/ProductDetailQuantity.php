<?php

namespace App\projection;
class ProductDetailQuantity
{
    public int|null $id;
    public string $title;
    public string $description;
    public string $distributor;
    public int $price;
    public int $quantity;
    public string $imageUrl;

    /**
     * @param int|null $id
     * @param string $title
     * @param string $description
     * @param string $distributor
     * @param int $price
     * @param int $quantity
     * @param string $imageUrl
     */
    public function __construct(?int $id, string $title, string $description, string $distributor, int $price, int $quantity, string $imageUrl)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->distributor = $distributor;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->imageUrl = $imageUrl;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
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

    public function getDistributor(): string
    {
        return $this->distributor;
    }

    public function setDistributor(string $distributor): void
    {
        $this->distributor = $distributor;
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

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }




}
