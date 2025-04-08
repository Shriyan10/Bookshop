<?php

namespace App\service;


use App\exception\ApplicationException;
use App\repository\UserRepository;
use App\request\CreateUserRequest;
use Exception;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws ApplicationException
     */
    public function getAllUsers(): object
    {
        try {
            $start = 1;
            $limit = 5;
            $search = "";

            if (isset($_GET['start'])) {
                $start = $_GET['start'];
            }

            if (isset($_GET['limit'])) {
                $limit = $_GET['limit'];
            }

            if (isset($_GET['search'])) {
                $search = $_GET['search'];
            }

            return $this->userRepository->getAllUsers($start, $limit, $search);
        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function saveUser(CreateUserRequest $request): bool
    {
        try {
            return $this->userRepository->saveUser($request);
        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function getUserById(int $id): object|array|null
    {
        try {
            $user = $this->userRepository->getUserById($id);
            if (!$user) {
                throw new ApplicationException("User not found", 404);
            }
            return $user;
        } catch (ApplicationException $e) {
            throw $e;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function updateUser(int $userId, string $firstName, string $lastName, string $email, string $password, int $roleId, string $address, string $contactNo): bool
    {
        try {
            $userExists = $this->userRepository->userExists($userId);
            if (!$userExists) {
                throw new ApplicationException("User not found", 404);
            }

            return $this->userRepository->updateUser($userId, $firstName, $lastName, $email, $password, $roleId, $address, $contactNo);

        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function deleteUser(int $id): bool
    {
        try {
            $userExists = $this->userRepository->userExists($id);
            if (!$userExists) {
                throw new ApplicationException("User not found", 404);
            }

            return $this->userRepository->deleteUser($id);
        } catch (ApplicationException $e) {
            throw $e;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new ApplicationException($e);
        }
    }

}