<?php

namespace App\repository;

interface UserRepository {
    public function getAllUsers(int $start, int $limit, string $search): object;

    public function saveUser(string $firstName, string $lastName, string $email, string $password, string $roleId, string $address, string $contactNo): bool;

    public function getUserById(int $id): object|array|null;

    public function updateUser(int $userId, string $firstName, string $lastName, string $email, string $password, int $roleId, string $address, string $contactNo): bool;

    public function deleteUser(int $id): bool;

    public function userExists(int $userId): bool;

}


