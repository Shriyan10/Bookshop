<?php

declare(strict_types=1);
namespace App\request;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class CreateProductDetailRequest{

    #[SerializedName('title')]
    #[Type('string')]
    public string $title;

    #[SerializedName('description')]
    #[Type('string')]
    public string $description;

    #[SerializedName('price')]
    #[Type('int')]
    public int $price;

    #[SerializedName('imageUrl')]
    #[Type('string')]
    public string $imageUrl;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

}