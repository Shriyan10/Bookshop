<?php

namespace App\controller\api\customer;

use App\controller\api\RestController;
use App\exception\ApplicationException;
use App\response\ServerResponse;
use App\service\CheckoutService;
use App\util\ObjectMapper;


class CheckoutRestController extends RestController
{
    private CheckoutService $checkoutService;

    public function __construct(CheckoutService $checkoutService, ObjectMapper $objectMapper)
    {
        parent::__construct($objectMapper);
        $this->checkoutService = $checkoutService;
    }

    /**
     * @throws ApplicationException
     */
    public function checkout(): void
    {
        $this->checkoutService->checkout();
        $serverResponse = new ServerResponse(null, "Checkout success");
        $this->response(200, $serverResponse);
    }
}