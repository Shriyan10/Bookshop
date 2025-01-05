<?php
require 'vendor/autoload.php';

use App\Db\Database;
use App\mapper\impl\RoleMapper;
use App\model\Role;

$latte = new Latte\Engine;
$database = new Database();
$roles = $database -> queryAll("SELECT * FROM roles", new RoleMapper());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $role = new Role(
            null,
            $_POST['name'] ?? null
        );


        $result = $database->query(
            "INSERT INTO roles(name) VALUES('%s')",
            [
                $role->getName(),
            ],
        );
        if ($result) {
            header("Location: http://localhost/bookshop/RoleController.php");
        }
    } catch (Exception $e) {
        var_dump($e);
    }
}

$params = ['roles' => $roles];

// render to output
$latte->render('templates\add_role.latte', $params);