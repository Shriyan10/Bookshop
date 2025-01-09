<?php

namespace App\mapper\impl;

use App\dto\BookDetailStatistics;
use App\mapper\RowMapper;

class BookDetailStatsMapper implements RowMapper
{

    public function map($row): BookDetailStatistics
    {


        $bookDetailStatistics =  new BookDetailStatistics();
//        $row["title"],
//            $row["available"],
//            $row["sold"],
//            $row["damaged"],

        $bookDetailStatistics->title = $row["title"];
        $bookDetailStatistics->available = $row["available"];
        $bookDetailStatistics->sold = $row["sold"];
        $bookDetailStatistics->damaged = $row["damaged"];
        return $bookDetailStatistics;
    }
}