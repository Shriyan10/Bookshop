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


    function add($items = []): void
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $cart = $_SESSION['cart'];

        foreach ($items as $key => $value) {
            if (array_key_exists($key, $cart)){
                $cart[$key] = $cart[$key]+$value;
            }else{
                $cart[$key] = $value;
            }
        }

        $_SESSION['cart'] = $cart;

$this->redirect();


    }
}
