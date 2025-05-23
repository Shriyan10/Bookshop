<?php

namespace App\service;


use App\dto\CartDetail;
use App\exception\ApplicationException;
use App\repository\PaymentRepository;
use App\repository\ProductRepository;

class CheckoutService
{

    private ProductRepository $productRepository;
    private PaymentRepository $paymentRepository;

    /**
     * @param PaymentRepository $paymentRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(PaymentRepository $paymentRepository, ProductRepository $productRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @throws ApplicationException
     */
    public function checkout(): void
    {
        if (!isset($_SESSION['cart'])) {
            throw new ApplicationException("Cart doesn't exist", 404);
        }
        $cart = $_SESSION['cart'];

        $cartDetails = [];
        $grandTotal = 0;

        foreach ($cart as $productDetail) {
            $cartDetail = new CartDetail();
            $cartDetail->setQuantity($productDetail->quantity);
            $product = $this->productRepository->getProductDetail($productDetail->productDetailId);
            $cartDetail->setId($product->id);
            $cartDetail->setTitle($product->title);

            $totalAmount = $product->price * $productDetail->quantity;
            $grandTotal += $totalAmount;
            $cartDetail->setTotalAmount($totalAmount);
            array_push($cartDetails, $cartDetail);
        }


        $products = [];

        foreach ($cartDetails as $cartDetail) {
            $specificProducts = $this->productRepository->getAvailableProductByProductDetailIdAndQuantity($cartDetail->getId(), $cartDetail->getQuantity());
            $foundProducts = count($specificProducts);
            if($foundProducts < $cartDetail->getQuantity()){
                throw new ApplicationException("Only $foundProducts is available!", 400);
            }
            foreach ($specificProducts as $specificProduct) {
                array_push($products, $specificProduct);
            }
        }

        $this->updateProductInventory($products, $grandTotal);

        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * @throws ApplicationException
     */
    public function updateProductInventory(array $products, float|int $grandTotal): void
    {
        $task = function ($connection) use ($products, $grandTotal) {
            try {
                foreach ($products as $product) {
                    $this->productRepository->txnUpdateProduct($connection, $product->id, "SOLD");
                }

                $paymentId = $this->paymentRepository->savePayment($connection, $grandTotal, $_SESSION['user']->id);

                foreach ($products as $product) {
                    $this->paymentRepository->savePaymentDetail($connection, $product->id, $paymentId);
                }
            } catch (\Exception $e) {
                error_log($e->getMessage());
            }
        };

        $this->productRepository->database->transactionalQuery($task);
    }

}