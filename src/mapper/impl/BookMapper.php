<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\model\Book;

class BookMapper implements RowMapper
{

    public function map($row): Book
    {
         $book = new Book();
         $book->setId($row["id"]);
         $book->setStatus($row["status"]);
         $book->setBookDetailId($row["book_detail_id"]);
         $book->setCreatedDate($row["created_date"]);
         $book->setUpdatedDate($row["updated_date"]);

        return $book;
    }
}