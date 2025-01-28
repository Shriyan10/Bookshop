<?php

namespace App\model;
class BookDetail
{
    public int|null $id;
    public string $title;
    public string $author;
    public string $publisher;
    public string $isbn;
    public int $price;
    public string $imageUrl;

    /**
     * @param int|null $id
     * @param string $title
     * @param string $author
     * @param string $publisher
     * @param string $isbn
     * @param int $price
     * @param string $imageUrl
     */
    public function __construct(int|null $id, string $title, string $author, string $publisher, string $isbn, int $price, string $imageUrl)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->publisher = $publisher;
        $this->isbn = $isbn;
        $this->price = $price;
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

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): void
    {
        $this->publisher = $publisher;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): void
    {
        $this->isbn = $isbn;
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


}
