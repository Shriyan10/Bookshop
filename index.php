<?php

use App\db\Database;
use App\route\Router;
use Latte\Engine;

require 'vendor/autoload.php';
$uri = $_SERVER['REQUEST_URI'];

session_start();

$latte = new Engine();
$database = new Database();

(new Router($latte, $database))->route($uri);

