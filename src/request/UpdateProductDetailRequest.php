<?php

declare(strict_types=1);
namespace App\request;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class UpdateProductDetailRequest{

    #[SerializedName('productDetailId')]
    #[Type('int')]
    public int $productDetailId;

    #[SerializedName('title')]
    #[Type('string')]
    public string $title;

    #[SerializedName('author')]
    #[Type('string')]
    public string $author;

    #[SerializedName('description')]
    #[Type('string')]
    public string $description;

    #[SerializedName('distributor')]
    #[Type('string')]
    public string $distributor;

    #[SerializedName('price')]
    #[Type('int')]
    public int $price;

    #[SerializedName('imageUrl')]
    #[Type('string')]
    public string $imageUrl;

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

    public function getProductDetailId(): int
    {
        return $this->productDetailId;
    }

    public function setProductDetailId(int $productDetailId): void
    {
        $this->productDetailId = $productDetailId;
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