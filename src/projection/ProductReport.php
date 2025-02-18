<?php

namespace App\projection;
class ProductReport
{
    public int $id;
    public string $title;
    public string $status;
    public string $createdDate;
    public string|null $updatedDate;

    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    public function setCreatedDate(string $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
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