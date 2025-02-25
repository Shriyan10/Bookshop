<?php

namespace App\controller\customer;


use App\controller\BaseController;
use App\db\Database;
use App\mapper\impl\PaymentMapper;

use Exception;
use Latte\Engine;

class PaymentController extends BaseController
{
    public function __construct(Engine $latte, Database $database)
    {
        parent::__construct($latte, $database);
    }

    function viewPayments(): void
    {
        try {
            $query = "SELECT * FROM payments WHERE user_id =" .$_SESSION['user']->getId() ;
            $payment = $this->database->queryAll($query, new PaymentMapper());

            $params = [
                'payments' => $payment,
            ];

            $this->render('product/customer/payments', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }
}
