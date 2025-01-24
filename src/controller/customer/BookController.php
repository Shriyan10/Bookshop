<?php

namespace App\controller\customer;

use App\db\Database;
use App\mapper\impl\BookDetailMapper;
use Exception;
use Latte\Engine;

class BookController
{
    private Engine $latte;

    public function __construct(Engine $latte)
    {
        $this->latte = $latte;
    }


    function getAllBooks(int $start, int $limit, string $search): void
    {
        try {
            $database = new Database();
            $offset = ($start - 1) * $limit;

            $query = "";
            $countQuery = "";

            if (strlen($search) > 0) {
                $query = "SELECT * FROM book_details WHERE title LIKE '%$search%' LIMIT " . $limit . " OFFSET " . $offset;
                $countQuery = "SELECT COUNT(*) as count FROM book_details WHERE title LIKE '%$search%'";
            } else {
                $query = "SELECT * FROM book_details LIMIT " . $limit . " OFFSET " . $offset;
                $countQuery = "SELECT COUNT(*) as count FROM book_details";
            }

            $bookDetails = $database->queryAll($query, new BookDetailMapper());
            $total = $database->count($countQuery);

            $params = [
                "bookDetails" => $bookDetails,
                "start" => $start,
                "limit" => $limit,
                "total" => $total,
                "search" => $search
            ];
            $this->latte->render('templates\book_details\customer\list_books.latte', $params);
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/500");
        }
    }

    function getBookDetail(int $bookDetailId): void
    {

        try {
            $database = new Database();

            $query = "SELECT * FROM book_details where id=" . $bookDetailId;
            $bookDetail = $database->queryOne($query, new BookDetailMapper());

            $params = [
                'bookDetail' => $bookDetail
            ];



            $this->latte->render('templates\book_details\customer\book_details.latte', $params);
        } catch (Exception $e) {
            var_dump($e);
//            header("Location: http://localhost/bookshop/500");
        }
    }
}
