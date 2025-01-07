<?php
require 'vendor/autoload.php';

use App\Db\Database;
use App\mapper\impl\UserMapper;

$latte = new Latte\Engine;

$database = new Database();
$query = "SELECT u.id,
       u.contact_no,
       u.first_name,
       u.last_name,
       u.email,
       u.password,
       u.address,
       r.name as role_id
        from users u
         INNER JOIN roles r ON u.role_id = r.id";
$users = $database->queryAll($query, new UserMapper());


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $type = $_POST['type'];
        if(strcmp("DELETE", $type) == 0){
            $database->query("DELETE FROM users where id='%s'", [$_POST['userId']]);
            header("Location: http://localhost/bookshop/UserController.php");
        }elseif(strcmp("EDIT", $type) == 0){
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