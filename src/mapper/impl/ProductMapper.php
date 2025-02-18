<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\model\Product;

class ProductMapper implements RowMapper
{

    public function map($row): Product
    {
        $product = new Product();
        $product->setId($row["id"]);
        $product->setStatus($row["status"]);
        $product->setproductDetailId($row["product_detail_id"]);
        $product->setCreatedDate($row["created_date"]);
        $product->setUpdatedDate($row["updated_date"]);

        return $product;
    }
}