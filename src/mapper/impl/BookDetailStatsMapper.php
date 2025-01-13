<?php

namespace App\mapper\impl;

use App\projection\BookDetailStatistics;
use App\mapper\RowMapper;

class BookDetailStatsMapper implements RowMapper
{

    public function map($row): BookDetailStatistics
    {
        $bookDetailStatistics =  new BookDetailStatistics();

        $bookDetailStatistics->title = $row["title"];
        $bookDetailStatistics->available = $row["available"];
        $bookDetailStatistics->sold = $row["sold"];
        $bookDetailStatistics->damaged = $row["damaged"];
        return $bookDetailStatistics;
    }
}