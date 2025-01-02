<?php
global $database;
require 'vendor/autoload.php';

use App\Db\Database;
use App\mapper\impl\BookDetailMapper;
use App\model\BookDetail;

$latte = new Latte\Engine;
$database = new Database();

$query = "SELECT * FROM book_details WHERE id=".$_GET['bookId'];
$bookDetail = $database->queryOne($query, new BookDetailMapper());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $bookDetail = new BookDetail(
            $_GET['bookId'],
            $_POST['title'] ?? null,
            $_POST['author'] ?? null,
            $_POST['publisher'] ?? null,
            $_POST['isbn'] ?? null,
            $_POST['price'] ?? null,
            $_POST['imageUrl'] ?? null
        );

        $result = $database->query(
            "UPDATE book_details SET title='%s', image_url='%s', author='%s', publisher='%s', isbn='%s', price=%d where id=%d",
            [
                $bookDetail->getTitle(),
                $bookDetail->getImageUrl(),
                $bookDetail->getAuthor(),
                $bookDetail->getPublisher(),
                $bookDetail->getIsbn(),
                $bookDetail->getPrice(),
                $bookDetail->getId()
            ],
        );
        if ($result) {
            header("Location: http://localhost/bookshop/BookListController.php");
        }
    } catch (Exception $e) {
        var_dump($e);
    }
}

$params = [
    'bookDetail' => $bookDetail
];

// render to output
$latte->render('templates\edit_book.latte', $params);