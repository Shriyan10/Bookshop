<?php

namespace App\mapper\impl;

use App\dto\DropdownDTO;
use App\mapper\RowMapper;

class ProductDetailDropdownMapper implements RowMapper
{

    public function map($row): DropdownDTO
    {
        return new DropdownDTO(
            $row["id"],
            $row["title"]
        );
    }
}