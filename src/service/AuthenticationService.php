<?php

namespace App\service;


use App\dto\UserDTO;
use App\exception\ApplicationException;
use App\repository\RoleRepository;
use App\repository\UserRepository;
use App\route\APIRouter;
use Exception;

class AuthenticationService
{
    public const CUSTOMER_ROLE = "CUSTOMER";
    private UserRepository $userRepository;
    private RoleRepository $roleRepository;

    /**
     * @param RoleRepository $roleRepository
     * @param UserRepository $userRepository
     */
    public function __construct(RoleRepository $roleRepository, UserRepository $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }


    /**
     * @throws ApplicationException
     */
    public function login(string $email, string $password)
    {
        try {
            $user = $this->userRepository->getUserByEmailAndPassword($email, $password);
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
        } else {
            throw new ApplicationException("Unauthorized", 401);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function register(UserDTO $userDTO): bool
    {

        try {
            $userDTO->setRoleId($this->roleRepository->getRoleByName(self::CUSTOMER_ROLE)->getId());
            return $this->userRepository->saveUser($userDTO);
        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }
}