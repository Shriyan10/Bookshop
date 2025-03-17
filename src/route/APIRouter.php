<?php

namespace App\route;


use App\controller\api\admin\RoleRestController;
use App\controller\RestController;
use App\db\Database;
use App\exception\BaseException;
use App\repository\impl\RoleRepositoryMySQLImpl;
use App\response\ServerResponse;
use App\service\RoleService;
use Exception;

class APIRouter extends RestController
{

    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    function route(string $path): void
    {
        try {

            $roleController = new RoleRestController(new RoleService(new RoleRepositoryMySQLImpl($this->database)));

            if (str_contains($path, '/api/rest/generate-password')) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->response(200, new ServerResponse(["hashed" => password_hash($this->requestBody()['password'], PASSWORD_BCRYPT)], null));
                }
            }

            if (preg_match('#^/api/rest/roles/?$#', $path)) {

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $roleController->saveRole();
                } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $roleController->getAllRoles();
                }

            } else if (preg_match('#^/api/rest/roles\?id=\d+$#', $path)) {
                if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
//                    $roleController->updateRole($_GET['id']);
                } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $roleController->getRole($_GET['id']);
                }
            }
        } catch (BaseException $exception) {
            if ($exception->throwable()) {
                error_log('Exception: ' . $exception->throwable()->getMessage());
            }
            RestController::error($exception->getCode(), $exception->getMessage());
        } catch (Exception $exception) {
            error_log('Exception: ' . $exception->getMessage());
            RestController::error(500, $exception->getMessage());
        }
    }

}