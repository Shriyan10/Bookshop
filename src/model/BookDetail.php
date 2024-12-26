<?php

namespace App\model;
class BookDetail
{
    public $id;
    public $title;
    public $author;
    public $publisher;
    public $isbn;
    public $price;
    public $imageUrl;

    /**
     * @param $id
     * @param $title
     * @param $author
     * @param $publisher
     * @param $isbn
     * @param $price
     * @param $imageUrl
     */
    public function __construct($id, $title, $imageUrl, $author, $publisher, $isbn, $price)
    {
        $this->id = $id;
        $this->title = $title;
        $this->imageUrl = $imageUrl;
        $this->author = $author;
        $this->publisher = $publisher;
        $this->isbn = $isbn;
        $this->price = $price;
    }
}
