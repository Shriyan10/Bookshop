<?php

namespace App\service;

use App\exception\ApplicationException;
use App\repository\ProductRepository;
use App\request\CreateProductDetailRequest;
use App\request\CreateProductRequest;
use App\request\UpdateProductDetailRequest;
use App\request\UpdateProductRequest;
use Exception;

class CartService
{
    private CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }




}