<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\projection\ProductDetailQuantity;

class ProductDetailQuantityMapper implements RowMapper
{

    public function map($row): ProductDetailQuantity
    {
        return new ProductDetailQuantity(
            $row["id"],
            $row["title"],
            $row["author"],
            $row["publisher"],
            $row["isbn"],
            $row["price"],
            $row["image_url"],
            $row["quantity"]
        );
    }
}