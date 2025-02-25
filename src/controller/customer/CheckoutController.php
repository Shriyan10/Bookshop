<?php

namespace App\controller\customer;

use App\controller\AuthenticationController;
use App\controller\BaseController;
use App\db\Database;
use App\dto\CartDetail;
use App\mapper\impl\ProductDetailMapper;
use App\mapper\impl\ProductMapper;
use Exception;
use Latte\Engine;

class CheckoutController extends BaseController
{
    public function __construct(Engine $latte, Database $database)
    {
        parent::__construct($latte, $database);
    }


    function checkout(): void
    {

        $auth = new AuthenticationController($this->latte, $this->database);

        if(!$auth->isLoggedIn()){
            $this->redirect("login");
        }


        $cart = $_SESSION['cart'];

        $cartDetails = [];
        $grandTotal = 0;
        foreach ($cart as $productDetailId => $quantity) {

            $cartDetail = new CartDetail();
            $cartDetail->setQuantity($quantity);
            $cartDetail->setId($productDetailId);

            $bookDetail = $this->database->queryOne("SELECT * FROM product_details WHERE id=$productDetailId", new ProductDetailMapper());
            $title = $bookDetail->title;
            $cartDetail->setTitle($title);
            $totalAmount = $bookDetail->price*$quantity;
            $grandTotal += $totalAmount;
            $cartDetail->setTotalAmount($totalAmount);
            array_push($cartDetails, $cartDetail);
        }

        $products = [];
        foreach ($cartDetails as $cartDetail) {
          $specificProducts =   $this -> database ->queryAll("SELECT * FROM products WHERE product_detail_id={$cartDetail->getId()} AND status='AVAILABLE' LIMIT {$cartDetail->getQuantity()}", new ProductMapper());

          foreach ($specificProducts as $specificProduct) {
              array_push($products, $specificProduct);
          }
        }

        foreach ($products as $product) {
            $sql = "UPDATE products SET status='SOLD' WHERE id=%d";
            $result = $this->database->query($sql, [$product->getId()]);
        }

        $paymentId = $this->database->queryWithId("INSERT into payments(total_cost,user_id) VALUES(%d,%d)", [$grandTotal, $_SESSION['user']->getId()]);

        foreach ($products as $product) {
            $sql = "INSERT INTO payment_details(product_id, payment_id) VALUES(%d,%d)";
            $result = $this->database->query($sql, [$product->getId(), $paymentId]);
        }
        if (isset($_SESSION['cart'])) {
            // Create a cart if it does not exist
            $_SESSION['cart'] = [];
        }


        $this->redirect();
    }
}
