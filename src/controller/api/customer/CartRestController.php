<?php

namespace App\controller\api\customer;

use App\controller\api\RestController;
use App\exception\ApplicationException;
use App\response\ServerResponse;
use App\service\CartService;
use App\util\ObjectMapper;


class CartRestController extends RestController
{
    private CartService $cartService;

    public function __construct(CartService $cartService, ObjectMapper $objectMapper)
    {
        parent::__construct($objectMapper);
        $this->cartService = $cartService;
    }


}