<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\projection\ProductDetailStatistics;

class ProductDetailStatsMapper implements RowMapper
{

    public function map($row): ProductDetailStatistics
    {
        $bookDetailStatistics = new ProductDetailStatistics();

        $bookDetailStatistics->title = $row["title"];
        $bookDetailStatistics->available = $row["available"];
        $bookDetailStatistics->sold = $row["sold"];
        $bookDetailStatistics->damaged = $row["damaged"];
        return $bookDetailStatistics;
    }
}