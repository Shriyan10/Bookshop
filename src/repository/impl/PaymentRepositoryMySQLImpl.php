<?php

namespace App\repository\impl;


use App\db\Database;
use App\mapper\impl\PaymentMapper;
use App\repository\BaseRepository;
use App\repository\PaymentRepository;


class PaymentRepositoryMySQLImpl extends BaseRepository implements PaymentRepository
{
    public function __construct(Database $database)
    {
        parent::__construct($database);
    }


    public function viewPayments(): array
    {

        return $this->database->queryAll(
            "SELECT * FROM payments WHERE user_id =" . $_SESSION['user']->getId(),
            new PaymentMapper()
        );
    }
}


