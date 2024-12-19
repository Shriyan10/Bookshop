<?php
require 'vendor/autoload.php';

use App\Db\Database;
use App\mapper\impl\RoleMapper;

$latte = new Latte\Engine;
$database = new Database();
$roles = $database -> queryAll("SELECT * FROM roles", new RoleMapper());

$params = [
    'roles' => $roles,
    'roles_heading' => 'Roles'
];

// render to output
$latte->render('templates\roles.latte', $params);
