<?php

namespace App\controller;


use App\Db\Database;
use App\mapper\impl\BookDetailMapper;
use App\mapper\impl\BookDetailStatsMapper;
use App\mapper\impl\BookMapper;
use App\mapper\impl\BookReportMapper;
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
        try {
            $database = new Database();
            $query = "SELECT * FROM book_details";

            $bookDetails = $database->queryAll($query, new BookDetailMapper());

            $params = [
                'bookDetails' => $bookDetails,
            ];

            $this->latte->render('templates\book_details\admin\list_book_detail.latte', $params);
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/500");
        }
    }

    function getBookDetails(int $bookDetailId): void
    {
        try {
            $database = new Database();

            $query = "SELECT * FROM book_details WHERE id=" . $bookDetailId;
            $bookDetail = $database->queryOne($query, new BookDetailMapper());

            $params = [
                'bookDetail' => $bookDetail,
            ];

            $this->latte->render('templates\book_details\admin\edit_book_detail.latte', $params);
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/500");
        }
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
                header("Location: http://localhost/bookshop/book-details/");
            }
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/500");
        }
    }


    function deleteBookDetails(int $bookId): void
    {
        try {
            $database = new Database();
            $result = $database->query("DELETE FROM book_details where id=%d", [$bookId]);
            if ($result) {
                header("Location: http://localhost/bookshop/book-details/");
            }
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/500");
        }
    }

    function saveBookDetailsPage(): void
    {
        try {
            $database = new Database();

            $bookDetails = $database->queryAll("SELECT * FROM book_details", new BookDetailMapper());

            $params = [
                'bookDetails' => $bookDetails
            ];

            // render to output
            $this->latte->render('templates\book_details\admin\add_book_detail.latte', $params);
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/500");
        }
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
                header("Location: http://localhost/bookshop/book-details/");
            }
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/500");
        }
    }

    function statistics(int $bookDetailId): void
    {
        try {
            $database = new Database();

            $sql = "select title,
       (select count(*) from books where book_detail_id = " . $bookDetailId . " and status = 'SOLD') as sold,
       (select count(*) from books where book_detail_id =" . $bookDetailId . " and status = 'DAMAGED') as damaged,
       (select count(*) from books where book_detail_id = " . $bookDetailId . " and status = 'AVAILABLE') as available
        from book_details
        where id =" . $bookDetailId;

            $statistics = $database->queryOne(
                $sql,
                new BookDetailStatsMapper());

            $statistics->id = $bookDetailId;
            $params = [
                'statistics' => $statistics
            ];

            // render to output
            $this->latte->render('templates\book_details\admin\statistics_book_detail.latte', $params);
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/500");
        }
    }

    function saveBookPage(int|null $bookDetailId): void
    {
        $database = new Database();

        $bookDetails = $database->queryAll("SELECT * FROM book_details", new BookDetailMapper());

        $params = [
            'bookDetails' => $bookDetails,
            'selectedBookDetailId' => $bookDetailId
        ];

        // render to output
        $this->latte->render('templates\book_details\admin\add_book_inventory.latte', $params);
    }

    function saveBook(): void
    {
        try {
            $database = new Database();

            $bookDetailId = $_POST['bookDetailId'] ?? null;
            $quantity = $_POST['quantity'] ?? null;
            var_dump([$bookDetailId, $quantity]);
            $sql = "INSERT INTO books(book_detail_id) VALUES (%d)";
            for ($i = 0; $i < $quantity; $i++) {

                $database->query($sql, [$bookDetailId]);
            }

            header("Location: http://localhost/bookshop/book-details/");

        } catch (Exception $e) {
            var_dump($e);

        }
    }

    function getBookByBookDetailId(int $bookDetailId): void
    {
        $database = new Database();

        $bookDetail = $database->queryOne("SELECT * FROM book_details WHERE id=" . $bookDetailId, new BookDetailMapper());

        $books = $database->queryAll("select * from books where book_detail_id=" . $bookDetailId, new BookMapper());

        $params = [
            'books' => $books,
            'bookDetail' => $bookDetail
        ];
        $this->latte->render('templates\book_details\admin\list_book_inventory.latte', $params);

    }

    function getBookByBookDetailIdAndId(int $bookDetailId, int $bookId): void
    {
        $database = new Database();
        $bookDetail = $database->queryOne("SELECT * FROM book_details WHERE id=" . $bookDetailId, new BookDetailMapper());
        $books = $database->queryAll("select * from books where book_detail_id=" . $bookDetailId . " and id=" . $bookId, new BookMapper());

        $params = [
            'books' => $books,
            'bookDetail' => $bookDetail
        ];
        $this->latte->render('templates\book_details\admin\list_book_inventory.latte', $params);
    }

    function getBookDetailInventoryByBookDetailId(int $bookDetailId, string $createdDate): void
    {
        if ($bookDetailId === -1) {
            $this->getBookDetailInventory();
            return;
        }

        $database = new Database();
        $sql = "select b.id,  bd.title, b.status, b.created_date, b.updated_date from books b INNER JOIN book_details bd ON b.book_detail_id=bd.id";

        if ($bookDetailId > 0) {
            $sql .= " where bd.id = " . $bookDetailId;
            if (strlen($createdDate) !== 0) {
                $sql .= " and DATE(b.created_date) = DATE('" . $createdDate . "')";
            }
        } else {
            if (strlen($createdDate) !== 0) {
                $sql .= " where DATE(b.created_date) = DATE('" . $createdDate . "')";
            }
        }
        $books = $database->queryAll($sql, new BookReportMapper());
        $bookDetails = $database->queryAll("SELECT * FROM book_details", new BookDetailMapper());

        $params = [
            'books' => $books,
            'bookDetails' => $bookDetails
        ];
        $this->latte->render('templates\book_details\admin\list_book_detail_inventory.latte', $params);

    }

    function getBookDetailInventory(): void
    {
        $database = new Database();

        $books = $database->queryAll("select b.id,  bd.title, b.status, b.created_date, b.updated_date from books b INNER JOIN book_details bd ON b.book_detail_id=bd.id;", new BookReportMapper());
        $bookDetails = $database->queryAll("SELECT * FROM book_details", new BookDetailMapper());
        $params = [
            'books' => $books,
            'bookDetails' => $bookDetails
        ];
        $this->latte->render('templates\book_details\admin\list_book_detail_inventory.latte', $params);

    }
}
