<?php

namespace App\repository;

interface PaymentRepository
{
    public function viewPayments(): array;
    public function savePayment(\mysqli $connection, int $grandTotal, int $userId): int;
    public function savePaymentDetail(\mysqli $connection, int $productId, int $paymentId): int;
}


