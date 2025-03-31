<?php

namespace App\controller\api;

use App\controller\RestController;
use App\dto\UserDTO;
use App\exception\ApplicationException;
use App\response\ServerResponse;
use App\service\AuthenticationService;

class AuthenticationRestController extends RestController
{
    private AuthenticationService $authenticationService;
    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @throws ApplicationException
     */
    function login(): void
    {
        $this->authenticationService->login($this->requestBody()['email'], $this->requestBody()['password']);
        $serverResponse = new ServerResponse("Login successful");
        header('Set-Cookie: PHPSESSID=' .session_id().'; path=/');
        $this->response(200, $serverResponse);
    }

    /**
     * @throws ApplicationException
     */
    function logout(): void
    {
        $this->authenticationService->logout();
        $serverResponse = new ServerResponse("Logout successful");
        $this->response(200, $serverResponse);
    }

    /**
     * @throws ApplicationException
     */
    function register(): void
    {
        $userDTO = new UserDTO(
            $this->requestBody() ['firstName'],
            $this->requestBody()['lastName'],
            $this->requestBody()['email'],
            $this->requestBody()['password'],
            null,
            $this->requestBody()['address'],
            $this->requestBody()['contactNo']
        );
        $success = $this->authenticationService->register($userDTO);
        if ($success) {
            $serverResponse = new ServerResponse(null, "Register successful");
            $this->response(201, $serverResponse);
        } else {
            throw new ApplicationException("Register failed", 500);
        }
    }
}



