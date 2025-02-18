<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\projection\ProductDetailStatistics;

class ProductDetailStatsMapper implements RowMapper
{

    public function map($row): ProductDetailStatistics
    {
        $productDetailStatistics = new ProductDetailStatistics();

        $productDetailStatistics->title = $row["title"];
        $productDetailStatistics->available = $row["available"];
        $productDetailStatistics->sold = $row["sold"];
        $productDetailStatistics->damaged = $row["damaged"];
        return $productDetailStatistics;
    }
}