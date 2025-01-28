<?php

namespace App\controller;


use App\db\Database;
use Latte\Engine;


class BaseController
{

    protected Engine $latte;
    protected Database $database;

    public function __construct(Engine $latte, Database $database)
    {
        $this->latte = $latte;
        $this->database = $database;
    }


    function render(string $view, $params = []): void
    {
        if (isset($_SESSION['user'])) {
            $params['isLoggedIn'] = true;
            $params['LOGGED_IN_USER'] = $_SESSION['user'];
        } else {
            $params['isLoggedIn'] = false;
            $params['LOGGED_IN_USER'] = null;
        }

        $quantity = 0;

        if(isset($_SESSION["cart"])){

            $cart = $_SESSION["cart"];

            // Add all the quantities of the books in the cart
            foreach ($cart as $key => $value) {
                $quantity += $value;
            }

        }

        $params["quantity"] =$quantity;

        $this->latte->render("templates/" . $view . ".latte", $params);
    }

    function redirect(string $url=""): void
    {
        header("Location: http://localhost:9900/".$url);
    }

    function offset(int $start = 1, int $limit = 5): int{
        return ($start - 1) * $limit;
    }
}