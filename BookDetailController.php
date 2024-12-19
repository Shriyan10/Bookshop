<?php
require 'vendor/autoload.php';

use App\Db\Database;
use App\mapper\impl\BookDetailMapper;
use App\mapper\impl\RoleMapper;

$latte = new Latte\Engine;
$database = new Database();
$bookDetails = $database -> queryAll("SELECT * FROM book_details",  new BookDetailMapper());

$params = [
    'bookDetails' => $bookDetails
];

// render to output
$latte->render('templates\book_details.latte', $params);
