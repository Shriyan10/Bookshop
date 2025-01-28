<?php

namespace App\controller\customer;

use App\controller\BaseController;
use App\db\Database;
use App\mapper\impl\BookDetailMapper;
use Exception;
use Latte\Engine;

class BookController extends BaseController
{

    public function __construct(Engine $latte, Database $database)
    {
        parent::__construct($latte, $database);
    }

    function getAllBooks(int $start, int $limit, string $search): void
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
                "bookDetails" => $bookDetails,
                "start" => $start,
                "limit" => $limit,
                "total" => $total,
                "search" => $search
            ];

            $this->render('book_details\customer\list_books', $params);
        } catch (Exception $e) {
            $this->redirect("500");
        }
    }

    function getBookDetail(int $bookDetailId): void
    {

        try {

            $query = "SELECT * FROM book_details WHERE id=" . $bookDetailId;
            $bookDetail = $this->database->queryOne($query, new BookDetailMapper());
            $count = "SELECT count(*) as count FROM books WHERE book_detail_id=" . $bookDetailId;
            $totalBooks = $this->database->count($count);

            $params = [
                'bookDetail' => $bookDetail,
                'totalBooks' => $totalBooks
            ];

            $this->render('book_details\customer\book_details', $params);
        } catch (Exception $e) {
            var_dump($e);
            $this->redirect("500");
        }
    }
}
