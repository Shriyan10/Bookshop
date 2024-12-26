<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\model\BookDetail;

class BookDetailMapper implements RowMapper
{

    public function map($row): BookDetail
    {
        return new BookDetail(
            $row["id"],
            $row["title"],
            $row["image_url"],
            $row["author"],
            $row["publisher"],
            $row["isbn"],
            $row["price"]
        );
    }
}