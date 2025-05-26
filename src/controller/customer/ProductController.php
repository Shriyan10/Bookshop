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
                $query = "SELECT COUNT(*) as quantity, bd.* from products b JOIN product_details bd ON bd.id=b.product_detail_id WHERE bd.title LIKE '%$search%' AND b.status='AVAILABLE' GROUP BY bd.id LIMIT " . $limit . " OFFSET " . $offset;
                $countQuery = "SELECT COUNT(*) as count FROM product_details WHERE title LIKE '%$search%'";
            } else {
                $query = "SELECT COUNT(*) as quantity, bd.* from products b JOIN product_details bd ON bd.id=b.product_detail_id WHERE b.status='AVAILABLE' GROUP BY bd.id LIMIT " . $limit . " OFFSET " . $offset;
                $countQuery = "SELECT COUNT(*) as count FROM product_details";
            }

            $productDetails = $this->database->queryAll($query, new ProductDetailQuantityMapper());
            $total = $this->database->count($countQuery);

//            var_dump($query);

            $params = [
                "productDetails" => $productDetails,
                "start" => $start,
                "limit" => $limit,
                "total" => $total,
                "search" => $search
            ];

            $this->render('product/customer/list_product', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }

    function getProductDetail(int $productDetailId): void
    {

        try {

            $query = "select count(*) as quantity, pd.* from product_details pd INNER JOIN products p ON p.product_detail_id = pd.id WHERE pd.id =" . $productDetailId . " AND p.status = 'AVAILABLE' GROUP BY pd.id";
            $bookDetail = $this->database->queryOne($query, new ProductDetailQuantityMapper());

            $params = [
                'bookDetail' => $bookDetail
            ];

            $this->render('product/customer/product_details', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }
}
