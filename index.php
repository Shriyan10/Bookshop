<?php

use App\db\Database;
use App\route\Router;
use Dotenv\Dotenv;
use Latte\Engine;

require 'vendor/autoload.php';

$latte = new Engine();
$database = new Database();
$router = new Router($latte, $database);
$uri = $_SERVER['REQUEST_URI'];
// Check if the .env file exists before loading
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else{
    error_log("WARNING .env file not found");
}
//error_log( password_hash("admin", PASSWORD_BCRYPT));
session_start();
$router->route($uri);





