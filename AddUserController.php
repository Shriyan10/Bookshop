<?php
require 'vendor/autoload.php';

use App\Db\Database;
use App\mapper\impl\UserMapper;

$latte = new Latte\Engine;

$params = [
];

// render to output
$latte->render('templates\add_user.latte', $params);