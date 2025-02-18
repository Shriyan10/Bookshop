<?php

namespace App\controller\customer;

use App\controller\BaseController;
use App\db\Database;
use App\mapper\impl\ProductDetailMapper;
use App\mapper\impl\ProductDetailQuantityMapper;
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
                $query = "SELECT COUNT(*) as quantity, bd.* from products b JOIN product_details bd ON bd.id=b.book_detail_id WHERE bd.title LIKE '%$search%' GROUP BY bd.id LIMIT " . $limit . " OFFSET " . $offset;
                $countQuery = "SELECT COUNT(*) as count FROM product_details WHERE title LIKE '%$search%'";
            } else {
                $query = "SELECT COUNT(*) as quantity, bd.* from products b JOIN product_details bd ON bd.id=b.book_detail_id GROUP BY bd.id LIMIT " . $limit . " OFFSET " . $offset;
                $countQuery = "SELECT COUNT(*) as count FROM product_details";
            }

            $bookDetails = $this->database->queryAll($query, new ProductDetailQuantityMapper());
            $total = $this->database->count($countQuery);

            $params = [
                "bookDetails" => $bookDetails,
                "start" => $start,
                "limit" => $limit,
                "total" => $total,
                "search" => $search
            ];

            $this->render('book_details/customer/list_books', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }

    function getBookDetail(int $bookDetailId): void
    {

        try {

            $query = "SELECT * FROM product_details WHERE id=" . $bookDetailId;
            $bookDetail = $this->database->queryOne($query, new ProductDetailMapper());
            $count = "SELECT count(*) as count FROM products WHERE book_detail_id=" . $bookDetailId;
            $totalBooks = $this->database->count($count);

            $params = [
                'bookDetail' => $bookDetail,
                'totalBooks' => $totalBooks
            ];

            $this->render('book_details/customer/book_details', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }
}
