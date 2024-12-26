<?php
require 'vendor/autoload.php';

use App\Db\Database;
use App\mapper\impl\RoleMapper;
use App\model\User;

$latte = new Latte\Engine;
$database = new Database();
$roles = $database -> queryAll("SELECT * FROM roles", new RoleMapper());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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


        $result = $database->insert(
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
            header("Location: http://localhost/bookshop/UserController.php");
        }
    } catch (Exception $e) {
        var_dump($e);
    }
}

$params = ['roles' => $roles];

// render to output
$latte->render('templates\add_user.latte', $params);