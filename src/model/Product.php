<?php

namespace App\model;
class Product
{
    public int|null $id;
    public string $status;
    public int $productDetailId;
    public string $createdDate;
    public string|null $updatedDate;

    public function getproductDetailId(): int
    {
        return $this->productDetailId;
    }

    public function setproductDetailId(int $productDetailId): void
    {
        $this->productDetailId = $productDetailId;
    }

    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    public function setCreatedDate(string $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getUpdatedDate(): string|null
    {
        return $this->updatedDate;
    }

    public function setUpdatedDate(string|null $updatedDate): void
    {
        $this->updatedDate = $updatedDate;
    }


}
