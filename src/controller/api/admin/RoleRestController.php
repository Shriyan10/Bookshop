<?php

namespace App\controller\api\admin;

use App\controller\BaseController;
use App\db\Database;
use App\mapper\impl\RoleMapper;
use App\model\Role;
use App\response\ServerResponse;
use Exception;
use Latte\Engine;


class RoleRestController extends BaseController
{

    public function __construct(Engine $latte, Database $database)
    {
        parent::__construct($latte, $database);
    }

    function getAllRoles(): string
    {
        try {
            $query = "SELECT * FROM roles";

            $roles = $this->database->queryAll($query, new RoleMapper());
            $serverResponse = new ServerResponse($roles);
            return json_encode($serverResponse);

        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }
}