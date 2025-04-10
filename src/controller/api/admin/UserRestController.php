<?php

namespace App\controller\api\admin;

use App\controller\RestController;
use App\exception\ApplicationException;
use App\request\CreateUserRequest;
use App\request\UpdateUserRequest;
use App\response\ServerResponse;
use App\service\UserService;
use App\util\ObjectMapper;


class UserRestController extends RestController
{
    private UserService $userService;

    public function __construct(UserService $userService, ObjectMapper $objectMapper)
    {
        parent::__construct($objectMapper);
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
        $request = $this->requestModel(CreateUserRequest::class);
        $success = $this->userService->saveUser($request);

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
    function updateUser(): void
    {

        $request = $this->requestModel(UpdateUserRequest::class);
        $success = $this->userService->updateUser($request);

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