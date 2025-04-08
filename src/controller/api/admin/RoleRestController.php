<?php

namespace App\controller\api\admin;

use App\controller\RestController;
use App\exception\ApplicationException;
use App\response\ServerResponse;
use App\service\RoleService;
use App\util\ObjectMapper;


class RoleRestController extends RestController
{
    private RoleService $roleService;

    public function __construct(RoleService $roleService, ObjectMapper $objectMapper)
    {
        parent::__construct($objectMapper);
        $this->roleService = $roleService;
//        error_log("Role rest controller ko object banyo hai");
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


    /**
     * @throws ApplicationException
     */
    function updateRole(int $roleId): void
    {

        $success = $this->roleService->updateRole($roleId, $this->requestBody()['name']);

        if ($success) {
            $serverResponse = new ServerResponse(null, "Role has been updated");
            $this->response(200, $serverResponse);
        } else {
            throw new ApplicationException("Role update failed", 500);
        }
    }

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

    function deleteRole(int $id): void
    {
        $success = $this->roleService->deleteRole($id);

        if ($success) {
            $serverResponse = new ServerResponse(null, "Role has been deleted");
            $this->response(200, $serverResponse);
        } else {
            throw new ApplicationException("Role delete failed", 500);
        }
    }

}