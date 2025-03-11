<?php

namespace App\route;


use App\controller\admin\ProductController as AdminProductController;
use App\controller\admin\RoleController;
use App\controller\admin\UserController;
use App\controller\api\admin\RoleRestController;
use App\controller\AuthenticationController;
use App\controller\BaseController;
use App\controller\customer\CheckoutController;
use App\controller\customer\PaymentController;
use App\controller\customer\ProductController as CustomerProductController;
use App\controller\customer\CartController;
use App\db\Database;
use Latte\Engine;

class APIRouter extends BaseController
{
    public function __construct(Engine $latte, Database $database)
    {
        parent::__construct($latte, $database);
    }

    function route(string $path): void
    {
        if (preg_match('#^/api/rest/roles/?$#', $path)) {
            $roleController = new RoleRestController($this->latte, $this->database);
            header('Content-Type: application/json; charset=utf-8');
            echo $roleController->getAllRoles();
        }
    }

}