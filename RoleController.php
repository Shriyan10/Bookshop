<?php
require 'vendor/autoload.php';

use App\Db\Database;
use App\mapper\impl\RoleMapper;

$latte = new Latte\Engine;

$database = new Database();
$query = "SELECT * FROM roles";

$roles = $database -> queryAll($query, new RoleMapper());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $type = $_POST['type'];
        if(strcmp("DELETE", $type) == 0){
            $database->query("DELETE FROM roles where id=%d", [$_POST['roleId']]);
            header("Location: http://localhost/bookshop/RoleController.php");
        }elseif(strcmp("EDIT", $type) == 0){
            header("Location: http://localhost/bookshop/EditRoleController.php?roleId=" . $_POST['roleId']);
        }
    } catch (Exception $e) {
        var_dump($e);
    }
}

$params = [
    'roles' => $roles,
    'roles_heading' => 'Roles'
];

// render to output
$latte->render('templates\roles.latte', $params);
