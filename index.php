<?php

use App\route\Router;

require 'vendor/autoload.php';

(new Router())->route($_SERVER['REQUEST_URI']);

