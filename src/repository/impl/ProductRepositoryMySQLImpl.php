<?php

namespace App\repository\impl;


use App\db\Database;
use App\mapper\impl\ProductDetailDropdownMapper;
use App\mapper\impl\ProductDetailMapper;
use App\mapper\impl\ProductDetailQuantityMapper;
use App\mapper\impl\ProductDetailStatsMapper;
use App\mapper\impl\ProductMapper;
use App\mapper\impl\ProductReportMapper;
use App\repository\BaseRepository;
use App\repository\ProductRepository;

class ProductRepositoryMySQLImpl extends BaseRepository implements ProductRepository
{
    public function __construct(Database $database)
    {
        parent::__construct($database);
    }

    /**
     * @throws \Exception
     */
    public function getAllProductDetails(int $start, int $limit, string $search): object
    {
        $query = "SELECT * FROM product_details";
        $countQuery = "SELECT COUNT(*) as count FROM product_details";

        if (strlen($search) > 0) {
            $searchQuery = " WHERE title LIKE '%$search%'";
            $query .= $searchQuery;
            $countQuery .= $searchQuery;
        }

        return $this->database->queryAllPaginated($query, $countQuery, $start, $limit, new ProductDetailMapper());
    }

    public function getProductDetailById(int $productDetailId): object|null
    {
        $query = "SELECT * FROM product_details WHERE id=" . $productDetailId;
        return $this->database->queryOne($query, new ProductDetailMapper());
    }

    public function updateProductDetail(int $productDetailId, string $title, string $author, string $description, string $distributor, int $price, string $imageUrl): bool
    {
        return $this->database->query(
            "UPDATE product_details SET title='%s', image_url='%s', author='%s', description='%s', distributor='%s', price=%d where id=%d",
            [
                $title,
                $imageUrl,
                $author,
                $description,
                $distributor,
                $price,
                $productDetailId
            ],
        );
    }

    public function saveProductDetail(string $title, string $description, int $price, string $imageUrl): bool
    {
        return $this->database->query(
            "INSERT INTO product_details(title, image_url, description, price) VALUES('%s','%s','%s', %d)",
            [
                $title,
                $imageUrl,
                $description,
                $price,
            ],
        );
    }

    public function deleteProductDetail(int $productDetailId): bool
    {
        return $this->database->query(
            "DELETE FROM product_details where id=%d",
            [
                $productDetailId
            ]
        );
    }

    public function productDetailStatistics(int $productDetailId): object|null
    {
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

        return $statistics;

    }


    public function productDetailExists(int $productDetailId): bool
    {
        return $this->database->countWithQuery("product_details where id=$productDetailId") == 1;
    }

    /**
     * @throws \Exception
     */
    public function getAllProducts(int $start, int $limit, int $productDetailId, int $productId, string $createdDate): object
    {
        $query = "SELECT p.id,  pd.title, p.status, p.created_date, p.updated_date FROM products p INNER JOIN product_details pd ON p.product_detail_id=pd.id";
        $countQuery = "SELECT COUNT(*) as count FROM products p INNER JOIN product_details pd ON p.product_detail_id=pd.id";

        $condition = 0;

        if ($productDetailId > 0) {
            $condition++;
            $searchQuery = " WHERE pd.id=" . $productDetailId;
            $query .= $searchQuery;
            $countQuery .= $searchQuery;
        }

        if ($productId > 0) {
            if ($condition > 0) {
                $searchQuery = " AND p.id=" . $productId;
                $query .= $searchQuery;
                $countQuery .= $searchQuery;
            } else {
                $searchQuery = " WHERE p.id=" . $productId;
                $query .= $searchQuery;
                $countQuery .= $searchQuery;
            }
        }


        if (strlen($createdDate) > 0) {
            if ($condition > 0) {
                $searchQuery = " AND DATE(p.created_date) = DATE('" . $createdDate . "')";
                $query .= $searchQuery;
                $countQuery .= $searchQuery;
            } else {
                $searchQuery = " WHERE DATE(p.created_date) = DATE('" . $createdDate . "')";
                $query .= $searchQuery;
                $countQuery .= $searchQuery;
            }
        }

        return $this->database->queryAllPaginated($query, $countQuery, $start, $limit, new ProductReportMapper());
    }

    public function getProductInventoryById(int $id): object|null
    {
        $query = "SELECT * FROM products WHERE id=" . $id;
        return $this->database->queryOne($query, new ProductMapper());
    }

    public function getAllProductDetailsForDropdown(string $search): array
    {
        $query = "SELECT id,title FROM product_details";

        if (strlen($search) > 0) {
            $searchQuery = " WHERE title LIKE '%$search%'";
            $query .= $searchQuery;
        }

        return $this->database->queryAll($query, new ProductDetailDropdownMapper());
    }

    public function saveProduct(\mysqli $connection, int $productDetailId): bool
    {
        $sql = "INSERT INTO products(product_detail_id) VALUES (%d)";
        return $this->database->txnQuery($connection, $sql, [$productDetailId]);
    }

    public function updateProduct(int $id, string $status): bool
    {
        return $this->database->query(
            "UPDATE products SET status='%s' WHERE id=%d",
            [
                $status,
                $id
            ]
        );
    }

    public function deleteProduct(int $id): bool
    {
        return $this->database->query(
            "DELETE FROM products where id=%d",
            [
                $id
            ]
        );
    }

    public function productExists(int $productId): bool
    {
        return $this->database->countWithQuery("products where id=$productId") == 1;
    }

    /**
     * @throws \Exception
     */
    public function getAllProductDetailsQuantityByStatus(int $start, int $limit, string $search): object
    {
        if (strlen($search) > 0) {

            return $this->database->queryAllPaginated(
                "SELECT COUNT(*) as quantity, pd.* from products p JOIN product_details pd ON pd.id=p.product_detail_id WHERE p.status='AVAILABLE' AND pd.title LIKE '%$search%' GROUP BY pd.id",
                "SELECT count(*) as count FROM (SELECT COUNT(*) as quantity, pd.* from products p JOIN product_details pd ON pd.id=p.product_detail_id WHERE p.status='AVAILABLE' AND pd.title = '$search'GROUP BY pd.id) t",
                $start,
                $limit,
                new ProductDetailQuantityMapper()
            );
        } else {

            return $this->database->queryAllPaginated(
                "SELECT COUNT(*) as quantity, pd.* from products p JOIN product_details pd ON pd.id=p.product_detail_id WHERE p.status='AVAILABLE' GROUP BY pd.id",
                "SELECT count(*) as count FROM (SELECT COUNT(*) as quantity, pd.* from products p JOIN product_details pd ON pd.id=p.product_detail_id WHERE p.status='AVAILABLE' GROUP BY pd.id) t",
                $start,
                $limit,
                new ProductDetailQuantityMapper()
            );
        }
    }

    public function getProductDetail(int $id): object|null
    {
        return $this->database->queryOne(
            "SELECT COUNT(*) as quantity, pd.* from products p JOIN product_details pd ON pd.id=p.product_detail_id WHERE p.status='AVAILABLE' AND pd.id = $id GROUP BY pd.id",
            new ProductDetailQuantityMapper()
        );
    }
}




