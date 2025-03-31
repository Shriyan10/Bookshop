<?php

namespace App\repository\impl;


use App\db\Database;
use App\db\PaginatedResponse;
use App\dto\UserDTO;
use App\mapper\impl\UserMapper;
use App\repository\BaseRepository;
use App\repository\UserRepository;
use Exception;


class UserRepositoryMySQLImpl extends BaseRepository implements UserRepository
{
    public function __construct(Database $database)
    {
        parent::__construct($database);
    }

    /**
     * @throws Exception
     */
    public function getAllUsers(int $start = 1, int $limit = 10, string $search = ""): PaginatedResponse
    {
        $query = "SELECT u.id, u.first_name, u.last_name, u.email, u.address, u.contact_no, r.name AS role_id FROM users u JOIN roles r ON r.id=u.role_id";
        $countQuery = "SELECT COUNT(*) AS count FROM users u";

        if (strlen($search) > 0) {
            $searchQuery = " WHERE u.first_name LIKE '%$search%' OR u.last_name LIKE '%$search%'";
            $query .= $searchQuery;
            $countQuery .= $searchQuery;
        }

        return $this->database->queryAllPaginated($query, $countQuery, $start, $limit, new UserMapper());

    }

    public function saveUser(UserDTO $userDTO): bool
    {
        return $this->database->query(
            "INSERT INTO users(first_name, last_name, email, password, role_id, address, contact_no) VALUES('%s','%s','%s','%s', %d, '%s', %d)",
            [
                $userDTO->firstName,
                $userDTO->lastName,
                $userDTO->email,
                password_hash(trim($userDTO->password), PASSWORD_BCRYPT),
                $userDTO->roleId,
                $userDTO->address,
                $userDTO->contactNo
            ],
        );
    }

    public function getUserById(int $id): object|array|null
    {
        $query = "SELECT u.id, u.first_name, u.last_name, u.email, u.address, u.contact_no, r.name AS role_id FROM users u JOIN roles r ON r.id=u.role_id and u.id=" . $id;
        return $this->database->queryOne($query, new UserMapper());
    }

    public function updateUser(int $userId, string $firstName, string $lastName, string $email, string $password, int $roleId, string $address, string $contactNo): bool
    {
        return $this->database->query(
            "UPDATE users SET first_name='%s', last_name='%s', email='%s', role_id=%d, address='%s', contact_no=%d where id=%d",
            [
                $firstName,
                $lastName,
                $email,
                $roleId,
                $address,
                $contactNo,
                $userId
            ],
        );
    }

    public function deleteUser(int $id): bool
    {
        return $this->database->query(
            "DELETE FROM users where id=%d",
            [
                $id
            ],
        );
    }

    public function userExists(int $userId): bool
    {
        return $this->database->countWithQuery("users where id=$userId") == 1;
    }

    public function getUserByEmailAndPassword(string $email, string $password): ?object
    {
        $sql = "SELECT u.id, u.first_name, u.last_name, u.email, u.address, u.contact_no, r.name AS role_id, u.password FROM users u JOIN roles r ON u.role_id = r.id WHERE u.email='$email'";

        return $this->database->queryOne($sql, new UserMapper());
    }
}


