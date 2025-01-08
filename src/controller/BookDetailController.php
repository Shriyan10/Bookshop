<?php

namespace App\controller;


use App\Db\Database;
use App\mapper\impl\BookDetailMapper;
use App\model\BookDetail;
use Exception;
use Latte\Engine;

class BookDetailController
{
    private Engine $latte;

    public function __construct(Engine $latte)
    {
        $this->latte = $latte;
    }


    function getAllBookDetails(): void
    {
        $database = new Database();
        $query = "SELECT * FROM book_details";

        $bookDetails = $database->queryAll($query, new BookDetailMapper());

        $params = [
            'bookDetails' => $bookDetails,
        ];

        $this->latte->render('templates\books\book_list.latte', $params);
    }

    function getBookDetails(int $bookId): void
    {
        $database = new Database();

        $query = "SELECT * FROM book_details WHERE id=" . $bookId;
        $bookDetail = $database->queryOne($query, new BookDetailMapper());
        $bookDetails = $database->queryAll("SELECT * FROM book_details", new BookDetailMapper());

        $params = [
            'bookDetail' => $bookDetail,
        ];

        // render to output
        $this->latte->render('templates\users\edit_book.latte', $params);
    }


    function updateBookDetails(int $bookId): void
    {
        try {
            $bookDetail = new BookDetail(
                $bookId,
                $_POST['title'] ?? null,
                $_POST['author'] ?? null,
                $_POST['publisher'] ?? null,
                $_POST['isbn'] ?? null,
                $_POST['price'] ?? null,
                $_POST['imageUrl'] ?? null
            );
            $database = new Database();
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
            header("Location: http://localhost/bookshop/404");
        }
    }


    function deleteBookDetails(int $bookId): void
    {
        try {
            $database = new Database();
            $result = $database->query("DELETE FROM book_details where id=%d", [$bookId]);
            if ($result) {
                header("Location: http://localhost/bookshop/books/");
            }
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/404");
        }
    }

    function saveBookDetailsPage(): void
    {
        $database = new Database();

        $bookDetails = $database->queryAll("SELECT * FROM book_details", new BookDetailMapper());

        $params = [
            'bookDetails' => $bookDetails
        ];

        // render to output
        $this->latte->render('templates\books\add_book.latte', $params);
    }


    function saveBookDetails(): void
    {
        try {
            $database = new Database();
            $bookDetail = new BookDetail(
                null,
                $_POST['title'] ?? null,
                $_POST['author'] ?? null,
                $_POST['publisher'] ?? null,
                $_POST['isbn'] ?? null,
                $_POST['price'] ?? null,
                $_POST['imageUrl'] ?? null
            );

            $result = $database->query(
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
                header("Location: http://localhost/bookshop/books/");
            }
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/404");
        }
    }
}
