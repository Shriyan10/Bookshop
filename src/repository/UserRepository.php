<?php

namespace App\repository;

use App\dto\UserDTO;

interface UserRepository {
    public function getAllUsers(int $start, int $limit, string $search): object;

    public function saveUser(UserDTO $userDTO): bool;

    public function getUserById(int $id): object|array|null;

    public function updateUser(int $userId, string $firstName, string $lastName, string $email, string $password, int $roleId, string $address, string $contactNo): bool;

    public function deleteUser(int $id): bool;

    public function userExists(int $userId): bool;

    public function getUserByEmailAndPassword(string $email, string $password): ?object;

}


