<?php

namespace App\repository\impl;


use App\db\Database;
use App\mapper\impl\RoleMapper;
use App\repository\BaseRepository;
use App\repository\RoleRepository;

class RoleRepositoryMySQLImpl extends BaseRepository implements RoleRepository
{
    public function __construct(Database $database)
    {
        parent::__construct($database);
    }

    public function getAllRoles(): array
    {
        return $this->database->queryAll("SELECT * FROM roles", new RoleMapper());
    }

    public function getRoleById(int $id): object|null
    {
        return $this->database->queryOne("SELECT * FROM roles WHERE id=" . $id, new RoleMapper());
    }

    public function updateRole(int $id, string $name): bool
    {
        return $this->database->query(
            "UPDATE roles SET name='%s' where id=%d",
            [
                $name,
                $id
            ],
        );
    }

    public function deleteRole(int $id): bool
    {
        return $this->database->query(
            "DELETE FROM roles where id=%d",
            [
                $id
            ]
        );
    }

    public function saveRole(string $name): bool
    {
        return $this->database->query(
            "INSERT INTO roles(name) VALUES('%s')",
            [
                $name
            ],
        );
    }

    public function roleExists(int $id): bool
    {
        return $this->database->countWithQuery("roles where id=$id") == 1;
    }

    public function getRoleByName(string $name): ?object
    {
        return $this->database->queryOne("SELECT * FROM roles WHERE name='$name'", new RoleMapper());
    }
}


