<?php
require 'vendor/autoload.php';

use App\Db\Database;
use App\mapper\impl\UserMapper;

$latte = new Latte\Engine;

$database = new Database();

$users = $database -> queryAll("SELECT u.id, u.contact_no, u.first_name, u.last_name, u.email, u.password, u.address, r.name as role from users u INNER JOIN roles r ON u.role_id = r.id", new UserMapper());

$params = [
    'users' => $users,
    'users_heading' => 'Users'
];

// render to output
$latte->render('templates\users.latte', $params);