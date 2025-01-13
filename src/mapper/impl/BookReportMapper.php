<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\projection\BookReport;

class BookReportMapper implements RowMapper
{
    public function map($row): BookReport
    {
     $bookReport = new BookReport();

     $bookReport->id = $row['id'];
     $bookReport->title = $row['title'];
     $bookReport->status = $row['status'];
     $bookReport->createdDate = $row['created_date'];
     $bookReport->updatedDate = $row['updated_date'];

     return $bookReport;
    }
}