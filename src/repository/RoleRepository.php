<?php

namespace App\repository;

interface RoleRepository {
    public function getAllRoles(): array;
    public function getRoleById(int $id): object| null;
    public function updateRole(int $id, string $name): bool;
    public function deleteRole(int $id): bool;
    public function saveRole(string $name): bool;
    public function roleExists(int $id): bool;
}


