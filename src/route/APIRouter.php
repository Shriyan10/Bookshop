<?php

namespace App\route;


use App\controller\api\admin\RoleRestController;
use App\controller\RestController;
use App\db\Database;

class APIRouter extends RestController
{
    public function __construct(Database $database)
    {
        parent::__construct($database);
    }

    function route(string $path): void
    {
        if (preg_match('#^/api/rest/roles/?$#', $path)) {
            $roleController = new RoleRestController($this->database);
            $roleController->getAllRoles();
        }
    }

}