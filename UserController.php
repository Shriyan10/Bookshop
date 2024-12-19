<?php
require 'vendor/autoload.php';

use App\Db\Database;
use App\mapper\impl\UserMapper;

$latte = new Latte\Engine;

$database = new Database();

$users = $database -> queryAll("SELECT * FROM users", new UserMapper());

$params = [
    'users' => $users,
    'users_heading' => 'Users'
];

// render to output
$latte->render('templates\users.latte', $params);