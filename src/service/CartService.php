<?php

namespace App\service;

use App\exception\ApplicationException;
use App\repository\ProductRepository;
use App\request\UpdateCartRequest;

class CartService
{

    private ProductRepository $productRepository;

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @throws ApplicationException
     */
    public function updateCart(UpdateCartRequest $request)
    {
        if (!$this->productRepository->productDetailExists($request->productDetailId)) {
            throw new ApplicationException("Product doesn't exist", 404);
        }

        if (!isset($_SESSION['cart'])) {
            // Create a cart if it does not exist
            $_SESSION['cart'] = [];
        }

        $cart = $_SESSION['cart'];

        $alreadyExists = false;
        foreach ($cart as $item) {
            if ($item->productDetailId == $request->productDetailId) {
                $alreadyExists = true;
                $item->quantity = $item->quantity + $request->quantity;
            }
        }

        if (!$alreadyExists) {
            array_push($cart, $request);
        }

        $_SESSION['cart'] = $cart;
    }

    public function getCart(): mixed
    {
        if (!isset($_SESSION['cart'])) {
            return [];
        }

        return $_SESSION['cart'];
    }
}