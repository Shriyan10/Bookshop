<?php
require 'vendor/autoload.php';

use App\Db\Database;
use App\model\BookDetail;

$latte = new Latte\Engine;


$params = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $title = $_POST['title'] ?? null;
        $imageUrl = $_POST['imageUrl'] ?? null;
        $author = $_POST['author'] ?? null;
        $publisher = $_POST['publisher'] ?? null;
        $isbn = $_POST['isbn'] ?? null;
        $price = $_POST['price'] ?? null;

        $bookDetail = new BookDetail(null, $title, $imageUrl, $author, $publisher, $isbn, $price);
        $database = new Database();

        $result = $database->insert(sprintf("INSERT INTO book_details(title, image_url, author, publisher, isbn, price) VALUES('%s','%s','%s','%s', '%s', %d)", $title, $imageUrl, $author, $publisher, $isbn, $price));
        header("Location: http://localhost/bookshop/BookListController.php");
    } catch (Exception $e) {
        var_dump($e);
    }
}
// render to output
$latte->render('templates\add_book.latte', $params);