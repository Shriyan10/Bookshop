<?php

namespace App\controller\api\customer;

use App\controller\api\RestController;
use App\exception\ApplicationException;
use App\request\UpdateCartRequest;
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

    /**
     * @throws ApplicationException
     */
    public function updateCart(): void{
        $request = $this->requestModel(UpdateCartRequest::class);
        $this->cartService->updateCart($request);
        $serverResponse = new ServerResponse(null, "Cart updated successfully");
        $this->response(200, $serverResponse);
    }


    public function getCart(): void{
        $serverResponse = new ServerResponse($this->cartService->getCart());
        $this->response(200, $serverResponse);
    }

}