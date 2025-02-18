<?php

namespace App\controller\customer;

use App\controller\BaseController;
use App\db\Database;
use App\dto\CartDetail;
use App\mapper\impl\ProductDetailMapper;
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
            $cart = $_SESSION['cart'];

            $cartDetails = [];
            $grandTotal = 0;
            foreach ($cart as $productDetailId => $quantity) {

                $cartDetail = new CartDetail();
                $cartDetail->setQuantity($quantity);

                $bookDetail = $this->database->queryOne("SELECT * FROM product_details WHERE id=$productDetailId", new ProductDetailMapper());
                $title = $bookDetail->title;
                $cartDetail->setTitle($title);
                $totalAmount = $bookDetail->price*$quantity;
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
}
