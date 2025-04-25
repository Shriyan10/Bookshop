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
        try {
            $auth = new AuthenticationController($this->latte, $this->database);

            if (!$auth->isLoggedIn()) {
                $this->redirect("login");
                return;
            }

            if (!isset($_SESSION['cart'])) {
                $this->redirect();
                return;
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
                $totalAmount = $bookDetail->price * $quantity;
                $grandTotal += $totalAmount;
                $cartDetail->setTotalAmount($totalAmount);
                array_push($cartDetails, $cartDetail);
            }

            $products = [];
            foreach ($cartDetails as $cartDetail) {
                $specificProducts = $this->database->queryAll("SELECT * FROM products WHERE product_detail_id={$cartDetail->getId()} AND status='AVAILABLE' LIMIT {$cartDetail->getQuantity()}", new ProductMapper());

                foreach ($specificProducts as $specificProduct) {
                    array_push($products, $specificProduct);
                }
            }

            $this->updateProductInventory($products, $grandTotal);

            if (isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $this->callKhalti();

        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }


    public function callKhalti(): void
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://dev.khalti.com/api/v2/epayment/initiate/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "return_url": "http://127.0.0.1:9900/",
    "website_url": "http://127.0.0.1:9900/",
    "amount": 1300,
    "purchase_order_id": "test12",
    "purchase_order_name": "test",
    "customer_info": {
        "name": "Khalti Bahadur",
        "email": "example@gmail.com",
        "phone": "9800000123"
    },
    "product_details": [
        {
            "identity": "12313",
            "name": "Khalti logo",
            "total_price": 1300,
            "quantity": 1,
            "unit_price": 1300
        }
    ],
    "merchant_username": "merchant_name",
    "merchant_extra": "merchant_extra"
}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Key 859abd9677844443beea1cde201adaa7',
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        $responseArray = json_decode($response,true);

        header("Location: ".$responseArray["payment_url"]);

        curl_close($curl);
    }

    public function updateProductInventory(array $products, float|int $grandTotal): void
    {
        foreach ($products as $product) {
            $this->database->query("UPDATE products SET status='SOLD' WHERE id=%d", [$product->getId()]);
        }

        $paymentId = $this->database->queryWithId("INSERT into payments(total_cost,user_id) VALUES(%d,%d)", [$grandTotal, $_SESSION['user']->getId()]);

        foreach ($products as $product) {
            $this->database->query("INSERT INTO payment_details(product_id, payment_id) VALUES(%d,%d)", [$product->getId(), $paymentId]);
        }
    }
}
