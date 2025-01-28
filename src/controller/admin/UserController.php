<?php

namespace App\controller\admin;

use App\controller\BaseController;
use App\Db\Database;
use App\mapper\impl\RoleMapper;
use App\mapper\impl\UserMapper;
use App\model\User;
use Exception;
use Latte\Engine;


class UserController extends BaseController
{

    public function __construct(Engine $latte, Database $database)
    {
        parent::__construct($latte, $database);
    }

    function getAllUsers(int $start, int $limit, string $search): void
    {

        $offset = $this->offset($start, $limit);

        $query = "";
        $countQuery = "";

        if (strlen($search) > 0) {
            $query = "SELECT * FROM users WHERE first_name LIKE '%$search%' or last_name LIKE '%$search%' LIMIT " . $limit . " OFFSET " . $offset;
            $countQuery = "SELECT COUNT(*) as count FROM users WHERE first_name LIKE '%$search%' or last_name LIKE '%$search%'";
        } else {
            $query = "SELECT * FROM users LIMIT " . $limit . " OFFSET " . $offset;
            $countQuery = "SELECT COUNT(*) as count FROM users";
        }

        $users = $this->database->queryAll($query, new UserMapper());
        $total = $this->database->count($countQuery);

        $params = [
            'users' => $users,
            'start' => $start,
            'limit' => $limit,
            'total' => $total,
            'search' => $search
        ];

        $this->render('users\list_user', $params);
    }


    function getUser(int $userId): void
    {


        $query = "SELECT * FROM users WHERE id=" . $userId;
        $user = $this->database->queryOne($query, new UserMapper());
        $roles = $this->database->queryAll("SELECT * FROM roles", new RoleMapper());

        $params = [
            'user' => $user,
            'roles' => $roles
        ];

        // render to output

        $this->render('users\edit_user', $params);
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

            $result = $this->database->query(
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
                $this->redirect("users");
            }
        } catch (Exception $e) {
            $this->redirect("500");
        }
    }

    function deleteUser(int $userId): void
    {
        try {

            $result = $this->database->query("DELETE FROM users where id=%d", [$userId]);
            if ($result) {
                $this->redirect("users");
            }
        } catch (Exception $e) {
            $this->redirect("500");
        }
    }

    function saveUserPage(): void
    {
        $roles = $this->database->queryAll("SELECT * FROM roles", new RoleMapper());

        $params = [
            'roles' => $roles
        ];

        // render to output
        $this->render('users\add_user', $params);
    }

    function saveUser(): void
    {
        try {
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

            $result = $this->database->query(
                "INSERT INTO users(first_name, last_name, email, password, role_id, address, contact_no) VALUES('%s','%s','%s','%s', %d, '%s', %d)",
                [
                    $user->getFirstName(),
                    $user->getLastName(),
                    $user->getEmail(),
                    password_hash(trim($user->getPassword()), PASSWORD_BCRYPT),
                    $user->getRoleId(),
                    $user->getAddress(),
                    $user->getContactNo()
                ],
            );

            if ($result) {
                $this->redirect("users");
            }
        } catch (Exception $e) {
            $this->redirect("500");
        }
    }
}