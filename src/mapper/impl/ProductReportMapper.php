<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\projection\ProductReport;

class ProductReportMapper implements RowMapper
{
    public function map($row): ProductReport
    {
        $productReport = new ProductReport();

        $productReport->id = $row['id'];
        $productReport->title = $row['title'];
        $productReport->status = $row['status'];
        $productReport->createdDate = $row['created_date'];
        $productReport->updatedDate = $row['updated_date'];

        return $productReport;
    }
}