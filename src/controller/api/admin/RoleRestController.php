<?php

namespace App\controller\api\admin;

use App\controller\RestController;
use App\exception\ApplicationException;
use App\response\ServerResponse;
use App\service\RoleService;


class RoleRestController extends RestController
{
    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @throws ApplicationException
     */
    function getAllRoles(): void
    {
        $serverResponse = new ServerResponse($this->roleService->getAllRoles());
        $this->response(200, $serverResponse);
    }

    /**
     * @throws ApplicationException
     */
    function getRole(int $id): void
    {
        $serverResponse = new ServerResponse($this->roleService->getRoleById($id));
        $this->response(200, $serverResponse);
    }
//
//    }
//    function updateRole(int $roleId): void
//    {
//        $entityBody = file_get_contents('php://input');
//        $data = json_decode($entityBody, true);
//
//        try {
//            $result = $this->database->query(
//                "UPDATE roles SET name='%s' where id=%d",
//                [
//                    $data['name'],
//                    $roleId
//                ],
//            );
//
//            if ($result) {
//                $serverResponse = new ServerResponse(null, "Role has been updated");
//                $this->response(200, $serverResponse);
//            }
//        } catch (Exception $e) {
//            error_log($e->getMessage());
//            $this->redirect("500");
//        }
//    }
//
    /**
     * @throws ApplicationException
     */
    function saveRole(): void
    {
        $success = $this->roleService->saveRole($this->requestBody()['name']);

        if ($success) {
            $serverResponse = new ServerResponse(null, "Role has been created");
            $this->response(201, $serverResponse);
        } else {
            throw new ApplicationException("Role creation failed", 500);
        }
    }

}