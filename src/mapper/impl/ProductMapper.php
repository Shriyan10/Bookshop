<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\model\Product;

class ProductMapper implements RowMapper
{

    public function map($row): Product
    {
        $book = new Product();
        $book->setId($row["id"]);
        $book->setStatus($row["status"]);
        $book->setBookDetailId($row["book_detail_id"]);
        $book->setCreatedDate($row["created_date"]);
        $book->setUpdatedDate($row["updated_date"]);

        return $book;
    }
}