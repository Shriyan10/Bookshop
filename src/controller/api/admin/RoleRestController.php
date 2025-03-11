<?php

namespace App\controller\api\admin;

use App\controller\RestController;
use App\db\Database;
use App\mapper\impl\RoleMapper;
use App\response\ServerResponse;
use Exception;


class RoleRestController extends RestController
{

    public function __construct(Database $database)
    {
        parent::__construct($database);
    }

    function getAllRoles()
    {
        try {
            $query = "SELECT * FROM roles";
            $roles = $this->database->queryAll($query, new RoleMapper());
            $serverResponse = new ServerResponse($roles);
            $this->response(200, $serverResponse);

        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->error(500, $e->getMessage());
        }
    }
}