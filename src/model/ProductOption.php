<?php

namespace App\model;
class ProductOption
{
    public int|null $id;
    public string $title;
    public string $description;
    public int|null $price;
    public string $imageUrl;
    public bool $is_active;
    public int|null $parent_id;
    public bool $is_item;
    public int|null $super_id;

    /**
     * @param string $description
     * @param int|null $id
     * @param string $imageUrl
     * @param bool $is_active
     * @param bool $is_item
     * @param int|null $parent_id
     * @param int|null $price
     * @param int|null $super_id
     * @param string $title
     */
    public function  __construct(string $description, ?int $id, string $imageUrl, bool $is_active, bool $is_item, ?int $parent_id, ?int $price, ?int $super_id, string $title)
    {
        $this->description = $description;
        $this->id = $id;
        $this->imageUrl = $imageUrl;
        $this->is_active = $is_active;
        $this->is_item = $is_item;
        $this->parent_id = $parent_id;
        $this->price = $price;
        $this->super_id = $super_id;
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

    public function isIsActive(): bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
    }

    public function isIsItem(): bool
    {
        return $this->is_item;
    }

    public function setIsItem(bool $is_item): void
    {
        $this->is_item = $is_item;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(?int $parent_id): void
    {
        $this->parent_id = $parent_id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): void
    {
        $this->price = $price;
    }

    public function getSuperId(): ?int
    {
        return $this->super_id;
    }

    public function setSuperId(?int $super_id): void
    {
        $this->super_id = $super_id;
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
