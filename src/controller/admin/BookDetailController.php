<?php

namespace App\controller\admin;


use App\controller\BaseController;
use App\Db\Database;
use App\mapper\impl\BookDetailMapper;
use App\mapper\impl\BookDetailStatsMapper;
use App\mapper\impl\BookMapper;
use App\mapper\impl\BookReportMapper;
use App\model\BookDetail;
use Exception;
use Latte\Engine;

class BookDetailController extends BaseController
{
    public function __construct(Engine $latte, Database $database)
    {
        parent::__construct($latte, $database);
    }

    function getAllBookDetails(int $start, int $limit, string $search): void
    {
        try {
            $offset = $this->offset($start, $limit);

            $query = "";
            $countQuery = "";

            if (strlen($search) > 0) {
                $query = "SELECT * FROM book_details WHERE title LIKE '%$search%' LIMIT " . $limit . " OFFSET " . $offset;
                $countQuery = "SELECT COUNT(*) as count FROM book_details WHERE title LIKE '%$search%'";
            } else {
                $query = "SELECT * FROM book_details LIMIT " . $limit . " OFFSET " . $offset;
                $countQuery = "SELECT COUNT(*) as count FROM book_details";
            }

            $bookDetails = $this->database->queryAll($query, new BookDetailMapper());
            $total = $this->database->count($countQuery);

            $params = [
                'bookDetails' => $bookDetails,
                'start' => $start,
                'limit' => $limit,
                'total' => $total,
                'search' => $search
            ];
            $this->render('book_details/admin/list_book_detail', $params);
        } catch (Exception $e) {
            $this->redirect('500');
        }
    }

    function getBookDetails(int $bookDetailId): void
    {
        try {
            $query = "SELECT * FROM book_details WHERE id=" . $bookDetailId;
            $bookDetail = $this->database->queryOne($query, new BookDetailMapper());

            $params = [
                'bookDetail' => $bookDetail,
            ];

            $this->render('book_details/admin/edit_book_detail', $params);
        } catch (Exception $e) {
            $this->redirect("500");
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

            $result = $this->database->query(
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
                $this->redirect("book-details");
            }
        } catch (Exception $e) {
            $this->redirect("500");
        }
    }


    function deleteBookDetails(int $bookId): void
    {
        try {
            $result = $this->database->query("DELETE FROM book_details where id=%d", [$bookId]);
            if ($result) {
                $this->redirect("book-details");
            }
        } catch (Exception $e) {
            $this->redirect("500");
        }
    }

    function saveBookDetailsPage(): void
    {
        try {
            $bookDetails = $this->database->queryAll("SELECT * FROM book_details", new BookDetailMapper());

            $params = [
                'bookDetails' => $bookDetails
            ];

            // render to output
            $this->render('book_details/admin/add_book_detail', $params);
        } catch (Exception $e) {
            var_dump($e);
            $this->redirect("500");
        }
    }


    function saveBookDetails(): void
    {
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

            $result = $this->database->query(
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
                $this->redirect("book-details");
            }
        } catch (Exception $e) {
            var_dump($e);
            $this->redirect("500");
        }
    }

    function statistics(int $bookDetailId): void
    {
        try {
            $sql = "select title,
       (select count(*) from books where book_detail_id = " . $bookDetailId . " and status = 'SOLD') as sold,
       (select count(*) from books where book_detail_id =" . $bookDetailId . " and status = 'DAMAGED') as damaged,
       (select count(*) from books where book_detail_id = " . $bookDetailId . " and status = 'AVAILABLE') as available
        from book_details
        where id =" . $bookDetailId;

            $statistics = $this->database->queryOne(
                $sql,
                new BookDetailStatsMapper());

            $statistics->id = $bookDetailId;
            $params = [
                'statistics' => $statistics
            ];

            // render to output
            $this->render('book_details/admin/statistics_book_detail', $params);
        } catch (Exception $e) {
            $this->redirect("500");
        }
    }

    function saveBookPage(int|null $bookDetailId): void
    {
        $bookDetails = $this->database->queryAll("SELECT * FROM book_details", new BookDetailMapper());

        $params = [
            'bookDetails' => $bookDetails,
            'selectedBookDetailId' => $bookDetailId
        ];

        // render to output
        $this->render('book_details/admin/add_book_inventory', $params);
    }

    function saveBook(): void
    {
        try {
            $bookDetailId = $_POST['bookDetailId'] ?? null;
            $quantity = $_POST['quantity'] ?? null;
            $sql = "INSERT INTO books(book_detail_id) VALUES (%d)";
            for ($i = 0; $i < $quantity; $i++) {

                $this->database->query($sql, [$bookDetailId]);
            }

            $this->redirect("book-details");

        } catch (Exception $e) {
            $this -> redirect("500");
        }
    }

    function getBookByBookDetailId(int $bookDetailId, int $start = 1, int $limit = 5): void
    {
        $offset = $this->offset($start, $limit);
        $query = "SELECT * FROM books WHERE book_detail_id=" . $bookDetailId . " LIMIT " . $limit . " OFFSET " . $offset;
        $books = $this->database->queryAll($query, new BookMapper());
        $bookDetail = $this->database->queryOne("SELECT * FROM book_details WHERE id=" . $bookDetailId, new BookDetailMapper());
        $total = $this->database->count("SELECT COUNT(*) as count FROM books");

        $params = [
            'books' => $books,
            'bookDetail' => $bookDetail,
            'deleteRedirect' => 'book-details/inventory?bookDetailId=' . $bookDetailId,
            'start' => $start,
            'limit' => $limit,
            'total' => $total
        ];
        $this->render('book_details/admin/list_book_inventory', $params);
    }

    function getBookByBookDetailIdAndId(int $bookDetailId, int $bookId): void
    {
        $bookDetail = $this->database->queryOne("SELECT * FROM book_details WHERE id=" . $bookDetailId, new BookDetailMapper());
        $books = $this->database->queryAll("select * from books where book_detail_id=" . $bookDetailId . " and id=" . $bookId, new BookMapper());

        $params = [
            'books' => $books,
            'bookDetail' => $bookDetail
        ];
        $this->render('book_details/admin/list_book_inventory', $params);
    }

    function getBookDetailInventoryByBookDetailId(int|null $bookDetailId, string|null $createdDate, int|null|string $bookId, int $start = 1, int $limit = 5): void
    {
        if ($bookDetailId === -1) {
            $bookDetailId = null;
        }
        
        $offset = $this->offset($start, $limit);
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
        $sql .= " LIMIT " . $limit . " OFFSET " . $offset;

        $books = $this->database->queryAll($sql, new BookReportMapper());
        $bookDetails = $this->database->queryAll("SELECT * FROM book_details", new BookDetailMapper());
        $total = $this->database->count($countSql);
        $params = [
            'books' => $books,
            'bookDetails' => $bookDetails,
            'start' => $start,
            'limit' => $limit,
            'total' => $total
        ];
        $this->render('book_details/admin/list_book_detail_inventory', $params);

    }

    function getBookDetailInventory(int $start = 1, int $limit = 5): void
    {
        $offset = $this->offset($start, $limit);
        $query = "SELECT b.id,  bd.title, b.status, b.created_date, b.updated_date FROM books b INNER JOIN book_details bd ON b.book_detail_id=bd.id LIMIT " . $limit . " OFFSET " . $offset;
        $books = $this->database->queryAll($query, new BookReportMapper());
        $bookDetails = $this->database->queryAll("SELECT * FROM book_details", new BookDetailMapper());
        $total = $this->database->count("SELECT COUNT(*) as count FROM books");
        $params = [
            'books' => $books,
            'bookDetails' => $bookDetails,
            'deleteRedirect' => 'book-details/inventory',
            'start' => $start,
            'limit' => $limit,
            'total' => $total
        ];
        $this->render('book_details/admin/list_book_detail_inventory', $params);
    }

    function updateBookDetailInventoryPage(int $bookId): void
    {

        $sql = "select b.id,  bd.title, b.status, b.created_date, b.updated_date from books b INNER JOIN book_details bd ON b.book_detail_id=bd.id where b.id=" . $bookId;
        $bookDetail = $this->database->queryOne($sql, new BookReportMapper());
        $bookStatusList = ["AVAILABLE", "SOLD", "DAMAGED"];
        $params = [
            'bookStatusList' => $bookStatusList,
            'bookDetail' => $bookDetail
        ];
        $this->render('book_details/admin/update_book_inventory', $params);
    }

    function updateBookDetailInventory(int $bookId): void
    {
        $sql = "UPDATE books SET status='%s' WHERE id=%d";
        $result = $this->database->query($sql, [$_POST['status'], $bookId]);
        if ($result) {
            $this->redirect("book-details/inventory");
        }
    }

    function deleteBookDetailInventory(int $bookId, string $redirectUrl): void
    {
        $sql = "DELETE FROM books WHERE id=%d";
        $result = $this->database->query($sql, [$bookId]);

        if ($result) {
            $this->redirect($redirectUrl);
        }
    }
}
