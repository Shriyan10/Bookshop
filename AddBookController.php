<?php
require 'vendor/autoload.php';

use App\Db\Database;
use App\model\BookDetail;

$latte = new Latte\Engine;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $bookDetail = new BookDetail(
            null,
            $_POST['title'] ?? null,
            $_POST['author'] ?? null,
            $_POST['publisher'] ?? null,
            $_POST['isbn'] ?? null,
            $_POST['price'] ?? null,
            $_POST['imageUrl'] ?? null
        );
        $database = new Database();

        $result = $database->insert(
            "INSERT INTO book_details(title, image_url, author, publisher, isbn, price) VALUES('%s','%s','%s','%s', '%s', %d)",
            [
                $bookDetail->getTitle(),
                $bookDetail->getImageUrl(),
                $bookDetail->getAuthor(),
                $bookDetail->getPublisher(),
                $bookDetail->getIsbn(),
                $bookDetail->getPrice()
            ],
        );
        if ($result) {
            header("Location: http://localhost/bookshop/BookListController.php");
        }
    } catch (Exception $e) {
        var_dump($e);
    }
}

$params = [];
// render to output
$latte->render('templates\add_book.latte', $params);