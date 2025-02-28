<?php

namespace App\controller\customer;

use App\controller\BaseController;
use App\db\Database;
use App\mapper\impl\ProductDetailMapper;
use App\mapper\impl\ProductDetailQuantityMapper;
use Exception;
use Latte\Engine;

class ProductController extends BaseController
{

    public function __construct(Engine $latte, Database $database)
    {
        parent::__construct($latte, $database);
    }

    function getAllProducts(int $start, int $limit, string $search): void
    {
        try {
            $offset = $this->offset($start, $limit);

            $query = "";
            $countQuery = "";

            if (strlen($search) > 0) {
                $query = "SELECT COUNT(*) as quantity, bd.* from products b JOIN product_details bd ON bd.id=b.product_detail_id WHERE  b.status='AVAILABLE' AND bd.title LIKE '%$search%' GROUP BY bd.id LIMIT $limit OFFSET $offset";
                $countQuery = "SELECT count(*) FROM (SELECT COUNT(*) as quantity, bd.* from products b JOIN product_details bd ON bd.id=b.product_detail_id WHERE b.status='AVAILABLE' AND bd.title = '$search'GROUP BY bd.id) t";
            } else {
                $query = "SELECT COUNT(*) as quantity, bd.* from products b JOIN product_details bd ON bd.id=b.product_detail_id WHERE b.status='AVAILABLE' GROUP BY bd.id LIMIT $limit OFFSET $offset";
                $countQuery = "SELECT count(*) FROM (SELECT COUNT(*) as quantity, bd.* from products b JOIN product_details bd ON bd.id=b.product_detail_id WHERE b.status='AVAILABLE' GROUP BY bd.id) t";
            }
            error_log($query);
            error_log($countQuery);
            $productDetails = $this->database->queryAll($query, new ProductDetailQuantityMapper());
            $total = $this->database->count($countQuery);

            $params = [
                "productDetails" => $productDetails,
                "start" => $start,
                "limit" => $limit,
                "total" => $total,
                "search" => $search
            ];

            var_dump($params);

            $this->render('product/customer/list_product', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }

    function getProductDetail(int $productDetailId): void
    {

        try {

            $query = "SELECT * FROM product_details WHERE id=" . $productDetailId;
            $bookDetail = $this->database->queryOne($query, new ProductDetailMapper());
            $count = "SELECT count(*) as count FROM products WHERE product_detail_id=" . $productDetailId;
            $totalBooks = $this->database->count($count);

            $params = [
                'bookDetail' => $bookDetail,
                'totalBooks' => $totalBooks
            ];

            $this->render('product/customer/product_details', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }
}
