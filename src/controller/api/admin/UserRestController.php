<?php

namespace App\controller\api\admin;

use App\controller\RestController;
use App\exception\ApplicationException;
use App\response\ServerResponse;
use App\service\UserService;


class UserRestController extends RestController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @throws ApplicationException
     */
    function getAllUsers(): void
    {
        $serverResponse = new ServerResponse($this->userService->getAllUsers());
        $this->response(200, $serverResponse);
    }

    /**
     * @throws ApplicationException
     */
    function saveUser(): void
    {
        $success = $this->userService->saveUser($this->requestBody()['firstName'],$this->requestBody()['lastName'],$this->requestBody()['email'],$this->requestBody()['password'],$this->requestBody()['roleId'],$this->requestBody()['address'],$this->requestBody()['contactNo']);

        if ($success) {
            $serverResponse = new ServerResponse(null, "User has been created");
            $this->response(201, $serverResponse);
        } else {
            throw new ApplicationException("User creation failed", 500);
        }
    }

    /**
     * @throws ApplicationException
     */
    function getUser(int $id): void
    {
        $serverResponse = new ServerResponse($this->userService->getUserById($id));
        $this->response(200, $serverResponse);
    }

    /**
     * @throws ApplicationException
     */
    function updateUser(int $userId): void
    {

        $success = $this->userService->updateUser($userId, $this->requestBody()['firstName'],$this->requestBody()['lastName'],$this->requestBody()['email'],$this->requestBody()['password'],$this->requestBody()['roleId'],$this->requestBody()['address'],$this->requestBody()['contactNo']);

        if ($success) {
            $serverResponse = new ServerResponse(null, "User has been updated");
            $this->response(200, $serverResponse);
        } else {
            throw new ApplicationException("User update failed", 500);
        }
    }

    /**
     * @throws ApplicationException
     */
    function deleteUser(int $id): void
    {
        $success = $this->userService->deleteUser($id);

        if ($success) {
            $serverResponse = new ServerResponse(null, "User has been deleted");
            $this->response(200, $serverResponse);
        } else {
            throw new ApplicationException("User delete failed", 500);
        }
    }

}