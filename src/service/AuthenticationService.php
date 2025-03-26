<?php

namespace App\service;


use App\exception\ApplicationException;
use App\repository\AuthenticationRepository;
use App\repository\UserRepository;
use App\route\APIRouter;
use Exception;

class AuthenticationService
{
    private AuthenticationRepository $authenticationRepository;

    public function __construct(AuthenticationRepository $authenticationRepository)
    {
        $this->authenticationRepository = $authenticationRepository;
    }

    /**
     * @throws ApplicationException
     */
    public function login(string $email, string $password)
    {
        try {
            $user= $this->authenticationRepository->login($email, $password);
            if (!$user) {
                throw new ApplicationException("Username/Password is incorrect!", 401);
            } else {
                $isVerified = password_verify(trim($password), $user->getPassword());
                if ($isVerified) {
                    $_SESSION['user'] = $user;
                } else {
                    throw new ApplicationException("Username/Password is incorrect!", 401);
                }
            }
        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }


    /**
     * @throws ApplicationException
     */
    function logOut(): void
    {
        if (APIRouter::isLoggedIn()) {
            session_unset();
            session_destroy();
        }else{
            throw new ApplicationException("Unauthorized", 401);
        }
    }
}