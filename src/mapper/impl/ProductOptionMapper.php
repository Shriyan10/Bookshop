<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\model\ProductOption;

class ProductOptionMapper implements RowMapper
{

    public function map($row): ProductOption
    {
        return new ProductOption(
            $row["description"],
            $row["id"],
            $row["image_url"],
            $row["is_active"],
            $row["is_item"],
            $row["parent_id"],
            $row["price"],
            $row["super_id"],
            $row["title"],
        );
    }
}