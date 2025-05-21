<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\response\OptionResponse;

class ProductOptionMapper implements RowMapper
{

    public function map($row): OptionResponse
    {
        return new OptionResponse(
            $row["id"],
            $row["title"],
            $row["parent_id"],
            $row["is_item"],
            $row["super_id"],
            []
        );
    }
}