<?php

use App\controller\Router;

require 'vendor/autoload.php';

(new Router())->route($_SERVER['REQUEST_URI']);

