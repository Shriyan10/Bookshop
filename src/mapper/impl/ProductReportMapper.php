<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\projection\ProductReport;

class ProductReportMapper implements RowMapper
{
    public function map($row): ProductReport
    {
        $bookReport = new ProductReport();

        $bookReport->id = $row['id'];
        $bookReport->title = $row['title'];
        $bookReport->status = $row['status'];
        $bookReport->createdDate = $row['created_date'];
        $bookReport->updatedDate = $row['updated_date'];

        return $bookReport;
    }
}