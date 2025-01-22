<?php

namespace App\controller;

use App\Db\Database;
use App\mapper\impl\RoleMapper;
use App\mapper\impl\UserMapper;
use App\model\User;
use Exception;
use Latte\Engine;


class UserController
{
    private Engine $latte;

    public function __construct(Engine $latte)
    {
        $this->latte = $latte;
    }


    function getAllUsers(int $start = 1, int $limit = 5): void
    {
        $database = new Database();
        $offset = ($start - 1) * $limit;
        $query = "SELECT * FROM users LIMIT " . $limit . " OFFSET " . $offset;
        $users = $database->queryAll($query, new UserMapper());
        $total = $database->count("SELECT COUNT(*) as count FROM users");

        $params = [
            'users' => $users,
            'start' => $start,
            'limit' => $limit,
            'total' => $total
        ];

        $this->latte->render('templates\users\list_user.latte', $params);
    }


    function getUser(int $userId): void
    {
        $database = new Database();

        $query = "SELECT * FROM users WHERE id=" . $userId;
        $user = $database->queryOne($query, new UserMapper());
        $roles = $database->queryAll("SELECT * FROM roles", new RoleMapper());

        $params = [
            'user' => $user,
            'roles' => $roles
        ];

        // render to output
        $this->latte->render('templates\users\edit_user.latte', $params);
    }


    function updateUser(int $userId): void
    {
        try {
            $user = new User(
                $userId,
                $_POST['firstName'] ?? null,
                $_POST['lastName'] ?? null,
                $_POST['email'] ?? null,
                null,
                $_POST['roleId'] ?? null,
                $_POST['address'] ?? null,
                $_POST['contactNo'] ?? null
            );
            $database = new Database();
            $result = $database->query(
                "UPDATE users SET first_name='%s', last_name='%s', email='%s', role_id=%d, address='%s', contact_no=%d where id=%d",
                [
                    $user->getFirstName(),
                    $user->getLastName(),
                    $user->getEmail(),
                    $user->getRoleId(),
                    $user->getAddress(),
                    $user->getContactNo(),
                    $user->getId()
                ],
            );
            if ($result) {
                header("Location: http://localhost/bookshop/users/");
            }
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/404");
        }
    }

    function deleteUser(int $userId): void
    {
        try {
            $database = new Database();
            $result = $database->query("DELETE FROM users where id=%d", [$userId]);
            if ($result) {
                header("Location: http://localhost/bookshop/users/");
            }
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/404");
        }
    }

    function saveUserPage(): void
    {
        $database = new Database();

        $roles = $database->queryAll("SELECT * FROM roles", new RoleMapper());

        $params = [
            'roles' => $roles
        ];

        // render to output
        $this->latte->render('templates\users\add_user.latte', $params);
    }

    function saveUser(): void
    {
        try {
            $database = new Database();
            $user = new User(
                null,
                $_POST['firstName'] ?? null,
                $_POST['lastName'] ?? null,
                $_POST['email'] ?? null,
                $_POST['password'] ?? null,
                $_POST['roleId'] ?? null,
                $_POST['address'] ?? null,
                $_POST['contactNo'] ?? null
            );

            $result = $database->query(
                "INSERT INTO users(first_name, last_name, email, password, role_id, address, contact_no) VALUES('%s','%s','%s','%s', %d, '%s', %d)",
                [
                    $user->getFirstName(),
                    $user->getLastName(),
                    $user->getEmail(),
                    $user->getPassword(),
                    $user->getRoleId(),
                    $user->getAddress(),
                    $user->getContactNo()
                ],
            );

            if ($result) {
                header("Location: http://localhost/bookshop/users/");
            }
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/500");
        }
    }


}