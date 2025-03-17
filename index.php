<?php

use App\db\Database;
use App\route\APIRouter;
use App\route\Router;
use Dotenv\Dotenv;
use Latte\Engine;

require 'vendor/autoload.php';

$latte = new Engine();
$database = new Database();

$uri = $_SERVER['REQUEST_URI'];
// Check if the .env file exists before loading
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else {
    error_log("WARNING .env file not found");
}
session_start();

if (str_contains($uri, '/api/rest')) {
    $apiRouter = new APIRouter($database);
    $apiRouter->route($uri);
}else{
    $router = new Router($latte, $database);
    $router->route($uri);
}






