<?php
require 'vendor/autoload.php';

use App\Db\Database;
use App\mapper\impl\BookDetailMapper;

$latte = new Latte\Engine;
$database = new Database();


$bookDetails = $database -> queryAll("SELECT * FROM book_details",  new BookDetailMapper());

$params = [
    'bookDetails' => $bookDetails
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        $type = $_POST['type'];
        if(strcmp("DELETE", $type) == 0){
            $database->query("DELETE FROM book_details where id=%d", [$_POST['bookId']]);
            header("Location: http://localhost/bookshop/BookListController.php");
        }elseif(strcmp("EDIT", $type) == 0){

            header("Location: http://localhost/bookshop/EditBookController.php?bookId=" . $_POST['bookId']);
        }
    } catch (Exception $e) {
        var_dump($e);
    }
}

// render to output
$latte->render('templates\book_list.latte', $params);
