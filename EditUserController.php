<?php
require 'vendor/autoload.php';

use App\Db\Database;
use App\mapper\impl\RoleMapper;
use App\mapper\impl\UserMapper;
use App\model\User;

$latte = new Latte\Engine;
$database = new Database();
$roles = $database -> queryAll("SELECT * FROM roles", new RoleMapper());

$query = "SELECT * FROM users WHERE id=".$_GET['userId'];
$user = $database->queryOne($query, new UserMapper());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            header("Location: http://localhost/bookshop/UserController.php");
        }
    } catch (Exception $e) {
        var_dump($e);
    }
}

$params = [
    'roles' => $roles,
    'user' => $user
];

// render to output
$latte->render('templates\users\edit_user.latte', $params);