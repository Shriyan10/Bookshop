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
        $id = $_SESSION['user']->getId();
        return $this->database->queryAll(
            "SELECT * FROM payments WHERE user_id =$id AND is_active = 1",
            new PaymentMapper()
        );
    }

    public function savePayment(\mysqli $connection, int $grandTotal, int $userId): int
    {
        return $this->database->txnQuery($connection,
            "INSERT into payments(total_cost,user_id) VALUES(%d,%d)",
            [$grandTotal, $userId]
        );
    }

    public function savePaymentDetail(\mysqli $connection, int $productId, int $paymentId): int
    {
        return $this->database->txnQuery(
            $connection,
            "INSERT INTO payment_details(product_id, payment_id) VALUES(%d,%d)",
            [$productId, $paymentId]
        );
    }
}


