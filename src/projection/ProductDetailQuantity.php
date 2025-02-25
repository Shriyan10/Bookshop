<?php

namespace App\projection;
class ProductDetailQuantity
{
    public int|null $id;
    public string $title;
    public string $author;
    public string $description;
    public string $distributor;
    public int $price;
    public int $quantity;
    public string $imageUrl;


    public function __construct(int|null $id, string $title, string $author, string $publisher, string $isbn, int $price, string $imageUrl, int $quantity)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->description = $publisher;
        $this->distributor = $isbn;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->imageUrl = $imageUrl;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
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

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
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

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }


}
