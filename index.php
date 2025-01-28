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

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();
$router->route($uri);




