<?php

use App\route\Router;

require 'vendor/autoload.php';
$uri = $_SERVER['REQUEST_URI'];
(new Router())->route($uri);

