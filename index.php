<?php

use App\db\Database;
use App\route\Router;
use Latte\Engine;

require 'vendor/autoload.php';

$latte = new Engine();
$database = new Database();
$router = new Router($latte, $database);
$uri = $_SERVER['REQUEST_URI'];

error_log("path: ".$uri);
error_log("path: ". preg_match('#^/?(.*)?$#', $uri));

session_start();
$router->route($uri);




