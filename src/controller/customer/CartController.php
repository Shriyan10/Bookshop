<?php

namespace App\controller\customer;

use App\controller\BaseController;
use App\db\Database;
use App\dto\CartDetail;
use App\mapper\impl\ProductDetailMapper;
use App\mapper\impl\ProductDetailQuantityMapper;
use Exception;
use Latte\Engine;

class CartController extends BaseController
{
    public function __construct(Engine $latte, Database $database)
    {
        parent::__construct($latte, $database);
    }

    /**
     * $_SESSION['cart'] structure
     * [
     *  1 => 2,
     *  2 => 3
     * ]
     */
    function add($items = []): void
    {
        if (!isset($_SESSION['cart'])) {
            // Create a cart if it does not exist
            $_SESSION['cart'] = [];
        }

        $cart = $_SESSION['cart'];

        foreach ($items as $productDetailId => $quantity) {

            $productDetailIdExists = array_key_exists($productDetailId, $cart);

            if ($productDetailIdExists) {
                $totalQuantity = $cart[$productDetailId] + $quantity;
                $cart[$productDetailId] = $totalQuantity;
            } else {
                $cart[$productDetailId] = $quantity;
            }

        }

        $_SESSION['cart'] = $cart;

        $this->redirect();
    }

    function cart(): void
    {
        try {


            $cartDetails = [];
            $grandTotal = 0;

            if (!isset($_SESSION['cart'])) {


                $params = [
                    "cartDetails" => $cartDetails,
                    "grandTotal" => $grandTotal,
                ];

                $this->render('product/customer/cart_detail', $params);
                return;
            }


            $cart = $_SESSION['cart'];
            foreach ($cart as $productDetailId => $quantity) {

                $cartDetail = new CartDetail();
                $cartDetail->setQuantity($quantity);


                $query = "SELECT COUNT(*) as quantity, bd.* from products b JOIN product_details bd ON bd.id=b.product_detail_id WHERE b.status='AVAILABLE' AND bd.id=$productDetailId";

                $productDetail = $this->database->queryOne($query, new ProductDetailQuantityMapper());

                $title = $productDetail->title;
                $cartDetail->totalQuantity = $productDetail->quantity;
                $cartDetail->setTitle($title);
                $cartDetail->setId($productDetail->id);
                $totalAmount = $productDetail->price*$quantity;
                $grandTotal += $totalAmount;
                $cartDetail->setTotalAmount($totalAmount);
                array_push($cartDetails, $cartDetail);
            }

            $params = [
                "cartDetails" => $cartDetails,
                "grandTotal" => $grandTotal
            ];

            $this->render('product/customer/cart_detail', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }

    function updateCart($requestProductDetailId, $requestQuantity): void
    {
        try {

            $cartDetails = [];
            $grandTotal = 0;

            if (!isset($_SESSION['cart'])) {
                $this->redirect();
            }


            $cart = $_SESSION['cart'];
            foreach ($cart as $productDetailId => $quantity) {

                if($requestProductDetailId == $productDetailId) {
                    $cart[$productDetailId] = $requestQuantity;
                }
            }

            $_SESSION['cart'] = $cart;

            $this->redirect("cart");
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }

    function deleteCart($requestProductDetailId): void
    {
        try {

            $cartDetails = [];
            $grandTotal = 0;

            if (!isset($_SESSION['cart'])) {
                $this->redirect();
            }

            $cart = $_SESSION['cart'];

            $newCart = [];
            foreach ($cart as $productDetailId => $quantity) {
                if($requestProductDetailId != $productDetailId) {
                    $newCart[$productDetailId] = $quantity;
                }
            }

            $_SESSION['cart'] = $newCart;

            $this->redirect("cart");
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }
}
