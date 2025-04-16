<?php

namespace App\service;

use App\exception\ApplicationException;
use App\repository\PaymentRepository;
use Exception;

class PaymentService
{
    private PaymentRepository $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @throws ApplicationException
     */
    public function viewPayments()
    {
        try {
            return $this->paymentRepository->viewPayments();
        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }


}