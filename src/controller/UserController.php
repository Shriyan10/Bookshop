<?php
namespace App\controller;

use App\Db\Database;
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


function getAllUsers(): void
{
    global $latte;
    $database = new Database();
    $query = "SELECT * FROM users";

    $route = new Router();

    $users = $database->queryAll($query, new UserMapper());

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $type = $_POST['type'];
            if (strcmp("DELETE", $type) == 0) {
                $database->query("DELETE FROM users where id='%s'", [$_POST['userId']]);
                header("Location: http://localhost/bookshop/users");
            } elseif (strcmp("EDIT", $type) == 0) {
                header("Location: http://localhost/bookshop/EditUserController.php?userId=" . $_POST['userId']);
            }
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    $params = [
        'users' => $users,
        'users_heading' => 'Users'
    ];

// render to output
    $latte->render('templates\users\users.latte', $params);
}


function getUser(int $userId): void
{
    $database = new Database();

    $query = "SELECT * FROM users WHERE id=" . $userId;
    $user = $database->queryOne($query, new UserMapper());

    $params = [
        'user' => $user
    ];

    // render to output
    $this->latte->render('templates\users\edit_user.latte', $params);
}


function updateUser(int $userId): void
{
    try {
        $user = new User(
            $_GET['userId'],
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
            header("Location: http://localhost/bookshop/users");
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
            header("Location: http://localhost/bookshop/users");
        }
    } catch (Exception $e) {
        var_dump($e);
    }
}

}