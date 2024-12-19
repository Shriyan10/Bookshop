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

    /**
     * @param $id
     * @param $title
     * @param $author
     * @param $publisher
     * @param $isbn
     * @param $price
     */
    public function __construct($id, $title, $author, $publisher, $isbn, $price)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->publisher = $publisher;
        $this->isbn = $isbn;
        $this->price = $price;
    }


}
