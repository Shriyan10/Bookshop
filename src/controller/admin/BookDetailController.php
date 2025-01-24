<?php

namespace App\controller\admin;


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


    function getAllBookDetails(int $start, int $limit, string $search): void
    {
        try {
            $database = new Database();
            $offset = ($start - 1) * $limit;

            $query = "";
            $countQuery = "";

            if (strlen($search)>0){
                $query =  "SELECT * FROM book_details WHERE title LIKE '%$search%' LIMIT " . $limit . " OFFSET " . $offset;
                $countQuery = "SELECT COUNT(*) as count FROM book_details WHERE title LIKE '%$search%'";
            }else {
                $query = "SELECT * FROM book_details LIMIT " . $limit . " OFFSET " . $offset;
                $countQuery = "SELECT COUNT(*) as count FROM book_details";
            }

            $bookDetails = $database->queryAll($query, new BookDetailMapper());
            $total = $database->count($countQuery);

            $params = [
                'bookDetails' => $bookDetails,
                'start' => $start,
                'limit' => $limit,
                'total' => $total,
                'search' => $search
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
            $sql = "INSERT INTO books(book_detail_id) VALUES (%d)";
            for ($i = 0; $i < $quantity; $i++) {

                $database->query($sql, [$bookDetailId]);
            }

            header("Location: http://localhost/bookshop/book-details/");

        } catch (Exception $e) {
            var_dump($e);

        }
    }

    function getBookByBookDetailId(int $bookDetailId, int $start = 1, int $limit = 5): void
    {
        $database = new Database();
        $offset = ($start - 1) * $limit;
        $query = "SELECT * FROM books WHERE book_detail_id=" . $bookDetailId. " LIMIT " . $limit . " OFFSET " . $offset;
        $books = $database->queryAll($query, new BookMapper());
        $bookDetail = $database->queryOne("SELECT * FROM book_details WHERE id=" . $bookDetailId, new BookDetailMapper());
        $total= $database->count("SELECT COUNT(*) as count FROM books");

        $params = [
            'books' => $books,
            'bookDetail' => $bookDetail,
            'deleteRedirect' => '/bookshop/book-details/inventory?bookDetailId=' . $bookDetailId,
            'start' => $start,
            'limit' => $limit,
            'total' => $total
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

    function getBookDetailInventoryByBookDetailId(int|null $bookDetailId, string|null $createdDate, int|null|string $bookId, int $start = 1, int $limit = 5): void
    {
        if ($bookDetailId === -1) {
            $bookDetailId = null;
        }

        $database = new Database();
        $offset = ($start - 1) * $limit;
        $sql = "select b.id,  bd.title, b.status, b.created_date, b.updated_date from books b INNER JOIN book_details bd ON b.book_detail_id=bd.id";
        $countSql = "SELECT COUNT(*) as count FROM books";
        $isFilterPresent = false;

        $isBookDetailIdFilterPresent = false;
        $isBookIdFilterPresent = false;
        $isCreatedDateFilterPresent = false;

        if (strlen($bookDetailId)) {
            $isFilterPresent = true;
            $isBookDetailIdFilterPresent = true;
        }

        if (strlen($createdDate) !== 0) {
            $isFilterPresent = true;
            $isCreatedDateFilterPresent = true;
        }

        if (strlen($bookId) !== 0) {
            $isFilterPresent = true;
            $isBookIdFilterPresent = true;
        }

        if ($isFilterPresent) {
            $sql .= " WHERE ";
            $countSql .= " WHERE ";

            $filterStart = false;

            if ($isBookDetailIdFilterPresent) {
                if ($bookDetailId > 0) {
                    $sql .= "bd.id = " . $bookDetailId;
                    $countSql .= "book_detail_id = " . $bookDetailId;
                    $filterStart = true;
                }
            }

            if ($isCreatedDateFilterPresent) {

                if ($filterStart) {
                    $sql .= " AND ";
                    $countSql .= " AND ";
                }

                $sql .= "DATE(b.created_date) = DATE('" . $createdDate . "')";
                $countSql .= "DATE(created_date) = DATE('" . $createdDate . "')";
                $filterStart = true;

            }

            if ($isBookIdFilterPresent) {

                if ($filterStart) {
                    $sql .= " AND ";
                    $countSql .= " AND ";
                }

                if ($bookId > 0) {
                    $sql .= "b.id = " . $bookId;
                    $countSql .= "id = " . $bookId;
                }
            }
        }
        $sql .= " LIMIT "  . $limit . " OFFSET " . $offset;


        $books = $database->queryAll($sql, new BookReportMapper());
        $bookDetails = $database->queryAll("SELECT * FROM book_details", new BookDetailMapper());
        $total= $database->count($countSql);
        $params = [
            'books' => $books,
            'bookDetails' => $bookDetails,
            'start' => $start,
            'limit' => $limit,
            'total' => $total
        ];
        $this->latte->render('templates\book_details\admin\list_book_detail_inventory.latte', $params);

    }

    function getBookDetailInventory(int $start = 1, int $limit = 5): void
    {
        $database = new Database();
        $offset = ($start - 1) * $limit;
        $query = "SELECT b.id,  bd.title, b.status, b.created_date, b.updated_date FROM books b INNER JOIN book_details bd ON b.book_detail_id=bd.id LIMIT " . $limit . " OFFSET " . $offset;
        $books = $database->queryAll($query, new BookReportMapper());
        $bookDetails = $database->queryAll("SELECT * FROM book_details", new BookDetailMapper());
        $total= $database->count("SELECT COUNT(*) as count FROM books");
        $params = [
            'books' => $books,
            'bookDetails' => $bookDetails,
            'deleteRedirect' => '/bookshop/book-details/inventory',
            'start' => $start,
            'limit' => $limit,
            'total' => $total
        ];
        $this->latte->render('templates\book_details\admin\list_book_detail_inventory.latte', $params);

    }

    function updateBookDetailInventoryPage(int $bookId): void
    {
        $database = new Database();
        $sql = "select b.id,  bd.title, b.status, b.created_date, b.updated_date from books b INNER JOIN book_details bd ON b.book_detail_id=bd.id where b.id=" . $bookId;
        $bookDetail = $database->queryOne($sql, new BookReportMapper());
        $bookStatusList = ["AVAILABLE", "SOLD", "DAMAGED"];
        $params = [
            'bookStatusList' => $bookStatusList,
            'bookDetail' => $bookDetail
        ];
        $this->latte->render('templates\book_details\admin\update_book_inventory.latte', $params);

    }

    function updateBookDetailInventory(int $bookId): void
    {
        $database = new Database();
        $sql = "UPDATE books SET status='%s' WHERE id=%d";
        $result = $database->query($sql, [$_POST['status'], $bookId]);
        if ($result) {
            header("Location: http://localhost/bookshop/book-details/inventory");
        }
    }

    function deleteBookDetailInventory(int $bookId, string $redirectUrl): void
    {
        $database = new Database();
        $sql = "DELETE FROM books WHERE id=%d";
        $result = $database->query($sql, [$bookId]);

        if ($result) {
            header("Location: http://localhost" . $redirectUrl);
        }
    }
}
