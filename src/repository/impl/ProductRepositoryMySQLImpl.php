<?php

namespace App\repository\impl;


use App\db\Database;
use App\mapper\impl\ProductDetailDropdownMapper;
use App\mapper\impl\ProductDetailMapper;
use App\mapper\impl\ProductDetailQuantityMapper;
use App\mapper\impl\ProductDetailStatsMapper;
use App\mapper\impl\ProductReportMapper;
use App\projection\ProductDetailStatistics;
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

    public function saveProductDetail(string $title, string $author, string $description, string $distributor, int $price, string $imageUrl): bool
    {
        return $this->database->query(
            "INSERT INTO product_details(title, image_url, author, description, distributor, price) VALUES('%s','%s','%s','%s', '%s', %d)",
            [
                $title,
                $imageUrl,
                $author,
                $description,
                $distributor,
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
    public function getAllProducts(int $start, int $limit, int $productDetailId, int $productId): object
    {
        $query = "SELECT p.id,  pd.title, p.status, p.created_date, p.updated_date FROM products p INNER JOIN product_details pd ON p.product_detail_id=pd.id";
        $countQuery = "SELECT COUNT(*) as count FROM products p INNER JOIN product_details pd ON p.product_detail_id=pd.id";

        $condition = 0;

        if ($productDetailId > 0) {
            $condition++;
            $searchQuery = " WHERE pd.id=".$productDetailId;
            $query .= $searchQuery;
            $countQuery .= $searchQuery;
        }

        if ($productId > 0) {
            if($condition > 0){
                $searchQuery = " AND p.id=".$productId;
                $query .= $searchQuery;
                $countQuery .= $searchQuery;
            }else{
                $searchQuery = " WHERE p.id=".$productId;
                $query .= $searchQuery;
                $countQuery .= $searchQuery;
            }
        }


        var_dump($query);
        return $this->database->queryAllPaginated($query, $countQuery, $start, $limit, new ProductReportMapper());
    }

    public function getProductInventoryById(int $id): object|null
    {
        $query = "SELECT * FROM product_details WHERE id=" . $id;
        return $this->database->queryOne($query, new ProductDetailMapper());
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
}




