<?php
global $roles;
require 'vendor/autoload.php';

use App\Db\Database;
use App\mapper\impl\RoleMapper;
use App\model\Role;

$latte = new Latte\Engine;
$database = new Database();

$query = "SELECT * FROM roles WHERE id=".$_GET['roleId'];
$role = $database->queryOne($query, new RoleMapper());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $role = new Role(
            $_GET['roleId'],
            $_POST['roleName'] ?? null,
        );

        $result = $database->query(
            "UPDATE roles SET name='%s' where id=%d",
            [
                $role->getName(),
                $role->getId()
            ],
        );
        if ($result) {
            header("Location: http://localhost/bookshop/RoleController.php");
        }
    } catch (Exception $e) {
        var_dump($e);
    }
}

$params = [
    'role' => $role
];

// render to output
$latte->render('templates\roles\edit_role.latte', $params);