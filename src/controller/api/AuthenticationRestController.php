<?php

namespace App\controller\api;

use App\controller\RestController;
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

    function logout(): void
    {
        $this->authenticationService->logout();
        $serverResponse = new ServerResponse("Logout successful");
        $this->response(200, $serverResponse);
    }
}



