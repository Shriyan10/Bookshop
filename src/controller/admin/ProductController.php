<?php

namespace App\controller\admin;


use App\controller\BaseController;
use App\db\Database;
use App\mapper\impl\ProductDetailMapper;
use App\mapper\impl\ProductDetailStatsMapper;
use App\mapper\impl\ProductMapper;
use App\mapper\impl\ProductReportMapper;
use App\model\ProductDetail;
use Exception;
use Latte\Engine;

class ProductController extends BaseController
{
    public function __construct(Engine $latte, Database $database)
    {
        parent::__construct($latte, $database);
    }

    function getAllProductDetails(int $start, int $limit, string $search): void
    {
        try {
            $offset = $this->offset($start, $limit);

            $query = "";
            $countQuery = "";

            if (strlen($search) > 0) {
                $query = "SELECT * FROM product_details WHERE title LIKE '%$search%' LIMIT " . $limit . " OFFSET " . $offset;
                $countQuery = "SELECT COUNT(*) as count FROM product_details WHERE title LIKE '%$search%'";
            } else {
                $query = "SELECT * FROM product_details LIMIT " . $limit . " OFFSET " . $offset;
                $countQuery = "SELECT COUNT(*) as count FROM product_details";
            }

            $productDetails = $this->database->queryAll($query, new ProductDetailMapper());
            $total = $this->database->count($countQuery);

            $params = [
                'bookDetails' => $productDetails,
                'start' => $start,
                'limit' => $limit,
                'total' => $total,
                'search' => $search
            ];
            $this->render('product/admin/list_product_detail', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect('500');
        }
    }

    function getProductDetails(int $productDetailId): void
    {
        try {
            $query = "SELECT * FROM product_details WHERE id=" . $productDetailId;
            $bookDetail = $this->database->queryOne($query, new ProductDetailMapper());

            $params = [
                'bookDetail' => $bookDetail,
            ];

            $this->render('product/admin/edit_product_detail', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }


    function updateProductDetails(int $productId): void
    {
        try {
            $productDetail = new ProductDetail(
                $productId,
                $_POST['title'] ?? null,
                $_POST['author'] ?? null,
                $_POST['publisher'] ?? null,
                $_POST['isbn'] ?? null,
                $_POST['price'] ?? null,
                $_POST['imageUrl'] ?? null
            );

            $result = $this->database->query(
                "UPDATE product_details SET title='%s', image_url='%s', author='%s', publisher='%s', isbn='%s', price=%d where id=%d",
                [
                    $productDetail->getTitle(),
                    $productDetail->getImageUrl(),
                    $productDetail->getAuthor(),
                    $productDetail->getDescription(),
                    $productDetail->getDistributor(),
                    $productDetail->getPrice(),
                    $productDetail->getId()
                ],
            );
            if ($result) {
                $this->redirect("product-details");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }


    function deleteProductDetails(int $bookId): void
    {
        try {
            $result = $this->database->query("DELETE FROM product_details where id=%d", [$bookId]);
            if ($result) {
                $this->redirect("product-details");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }

    function saveProductDetailsPage(): void
    {
        try {
            $bookDetails = $this->database->queryAll("SELECT * FROM product_details", new ProductDetailMapper());

            $params = [
                'bookDetails' => $bookDetails
            ];

            // render to output
            $this->render('product/admin/add_product_detail', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }


    function saveProducts(): void
    {
        try {
            $bookDetail = new ProductDetail(
                null,
                $_POST['title'] ?? null,
                $_POST['author'] ?? null,
                $_POST['publisher'] ?? null,
                $_POST['isbn'] ?? null,
                $_POST['price'] ?? null,
                $_POST['imageUrl'] ?? null
            );

            $result = $this->database->query(
                "INSERT INTO product_details(title, image_url, author, description, distributor, price) VALUES('%s','%s','%s','%s', '%s', %d)",
                [
                    $bookDetail->getTitle(),
                    $bookDetail->getImageUrl(),
                    $bookDetail->getAuthor(),
                    $bookDetail->getDescription(),
                    $bookDetail->getDistributor(),
                    $bookDetail->getPrice()
                ],
            );
            if ($result) {
                $this->redirect("product-details");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }

    function statistics(int $productDetailId): void
    {
        try {
            $sql = "select title,
       (select count(*) from products where product_detail_id = " . $productDetailId . " and status = 'SOLD') as sold,
       (select count(*) from products where product_detail_id =" . $productDetailId . " and status = 'DAMAGED') as damaged,
       (select count(*) from products where product_detail_id = " . $productDetailId . " and status = 'AVAILABLE') as available
        from product_details
        where id =" . $productDetailId;

            $statistics = $this->database->queryOne(
                $sql,
                new ProductDetailStatsMapper());

            $statistics->id = $productDetailId;
            $params = [
                'statistics' => $statistics
            ];

            // render to output
            $this->render('product/admin/statistics_product_detail', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }

    function saveProductPage(int|null $productDetailId): void
    {
        $bookDetails = $this->database->queryAll("SELECT * FROM product_details", new ProductDetailMapper());

        $params = [
            'bookDetails' => $bookDetails,
            'productDetailId' => $productDetailId
        ];

        // render to output
        $this->render('product/admin/add_product_inventory', $params);
    }

    function saveProduct(): void
    {
        try {
            $productDetailId = $_POST['productDetailId'] ?? null;
            $quantity = $_POST['quantity'] ?? null;
            $sql = "INSERT INTO products(product_detail_id) VALUES (%d)";
            for ($i = 0; $i < $quantity; $i++) {

                $this->database->query($sql, [$productDetailId]);
            }

            $this->redirect("product-details");

        } catch (Exception $e) {
            error_log($e->getMessage());
            $this -> redirect("500");
        }
    }

    function getProductByProductDetailId(int $productDetailId, int $start = 1, int $limit = 5): void
    {
        $offset = $this->offset($start, $limit);
        $query = "SELECT * FROM products WHERE product_detail_id=" . $productDetailId . " LIMIT " . $limit . " OFFSET " . $offset;
        $products = $this->database->queryAll($query, new ProductMapper());
        $productDetail = $this->database->queryOne("SELECT * FROM product_details WHERE id=" . $productDetailId, new ProductDetailMapper());
        $total = $this->database->count("SELECT COUNT(*) as count FROM products");

        $params = [
            'products' => $products,
            'productDetail' => $productDetail,
            'deleteRedirect' => 'product-details/inventory?productDetailId=' . $productDetailId,
            'start' => $start,
            'limit' => $limit,
            'total' => $total
        ];
        $this->render('product/admin/list_product_inventory', $params);
    }

    function getProductByProductDetailIdAndId(int $productDetailId, int $bookId, int $start = 1, int $limit = 5): void
    {
        $offset = $this->offset($start, $limit);
        $bookDetail = $this->database->queryOne("SELECT * FROM product_details WHERE id=" . $productDetailId, new ProductDetailMapper());
        $products = $this->database->queryAll("select * from products where product_detail_id=" . $productDetailId . " and id=" . $bookId, new ProductMapper());
        $total = $this->database->count("SELECT COUNT(*) as count FROM products");
        $params = [
            'books' => $products,
            'bookDetail' => $bookDetail,
            'start' => $start,
            'limit' => $limit,
            'total' => $total
        ];
        $this->render('product/admin/list_product_inventory', $params);
    }

    function getBookDetailInventoryByProductDetailId(int|null $productDetailId, string|null $createdDate, int|null|string $bookId, int $start = 1, int $limit = 5): void
    {
        if ($productDetailId === -1) {
            $productDetailId = null;
        }
        
        $offset = $this->offset($start, $limit);
        $sql = "SELECT b.id,  bd.title, b.status, b.created_date, b.updated_date FROM products b INNER JOIN product_details bd ON b.product_detail_id=bd.id";
        $countSql = "SELECT COUNT(*) as count FROM products";
        $isFilterPresent = false;

        $isproductDetailIdFilterPresent = false;
        $isBookIdFilterPresent = false;
        $isCreatedDateFilterPresent = false;

        if (strlen($productDetailId)) {
            $isFilterPresent = true;
            $isproductDetailIdFilterPresent = true;
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

            if ($isproductDetailIdFilterPresent) {
                if ($productDetailId > 0) {
                    $sql .= "bd.id = " . $productDetailId;
                    $countSql .= "product_detail_id = " . $productDetailId;
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

        $products = $this->database->queryAll($sql, new ProductReportMapper());
        $bookDetails = $this->database->queryAll("SELECT * FROM product_details", new ProductDetailMapper());
        $total = $this->database->count($countSql);
        $params = [
            'products' => $products,
            'bookDetails' => $bookDetails,
            'start' => $start,
            'limit' => $limit,
            'total' => $total
        ];
        $this->render('product/admin/list_product_detail_inventory', $params);

    }

    function getProductDetailInventory(int $start = 1, int $limit = 5): void
    {
        $offset = $this->offset($start, $limit);
        $query = "SELECT b.id,  bd.title, b.status, b.created_date, b.updated_date FROM products b INNER JOIN product_details bd ON b.product_detail_id=bd.id LIMIT " . $limit . " OFFSET " . $offset;
        $products = $this->database->queryAll($query, new ProductReportMapper());
        $bookDetails = $this->database->queryAll("SELECT * FROM product_details", new ProductDetailMapper());
        $total = $this->database->count("SELECT COUNT(*) as count FROM products");
        $params = [
            'products' => $products,
            'bookDetails' => $bookDetails,
            'deleteRedirect' => 'product-details/inventory',
            'start' => $start,
            'limit' => $limit,
            'total' => $total
        ];
        $this->render('product/admin/list_product_detail_inventory', $params);
    }

    function updateProductDetailInventoryPage(int $bookId): void
    {

        $sql = "select b.id,  bd.title, b.status, b.created_date, b.updated_date from products b INNER JOIN product_details bd ON b.product_detail_id=bd.id where b.id=" . $bookId;
        $bookDetail = $this->database->queryOne($sql, new ProductReportMapper());
        $bookStatusList = ["AVAILABLE", "SOLD", "DAMAGED"];
        $params = [
            'bookStatusList' => $bookStatusList,
            'bookDetail' => $bookDetail
        ];
        $this->render('product/admin/update_product_inventory', $params);
    }

    function updateProductDetailInventory(int $bookId): void
    {
        $sql = "UPDATE products SET status='%s' WHERE id=%d";
        $result = $this->database->query($sql, [$_POST['status'], $bookId]);
        if ($result) {
            $this->redirect("product-details/inventory");
        }
    }

    function deleteProductDetailInventory(int $bookId, string $redirectUrl): void
    {
        $sql = "DELETE FROM products WHERE id=%d";
        $result = $this->database->query($sql, [$bookId]);

        if ($result) {
            $this->redirect($redirectUrl);
        }
    }
}
