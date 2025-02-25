<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\model\Payment;

class PaymentMapper implements RowMapper
{

    public function map($row): Payment
    {
        return new Payment(
            $row["id"],
            $row["total_cost"],
            $row["delivery_charge"],
            $row["user_id"],
        );
    }
}