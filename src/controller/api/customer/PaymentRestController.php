<?php

namespace App\controller\api\customer;

use App\controller\api\RestController;
use App\exception\ApplicationException;
use App\response\ServerResponse;
use App\service\PaymentService;
use App\util\ObjectMapper;

class PaymentRestController extends RestController
{
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService, ObjectMapper $objectMapper)
    {
        parent::__construct($objectMapper);
        $this->paymentService = $paymentService;
    }

    /**
     * @throws ApplicationException
     */
    function viewPayments(): void
    {
        $serverResponse = new ServerResponse($this->paymentService->viewPayments());
        $this->response(200, $serverResponse);
    }
}