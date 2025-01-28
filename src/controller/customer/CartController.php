<?php

namespace App\controller\customer;

use App\controller\BaseController;
use App\db\Database;
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

        foreach ($items as $bookDetailId => $quantity) {

            $bookDetailIdExists = array_key_exists($bookDetailId, $cart);

            if ($bookDetailIdExists) {
                $totalQuantity = $cart[$bookDetailId] + $quantity;
                $cart[$bookDetailId] = $totalQuantity;
            } else {
                $cart[$bookDetailId] = $quantity;
            }

        }

        $_SESSION['cart'] = $cart;

        $this->redirect();
    }
}
