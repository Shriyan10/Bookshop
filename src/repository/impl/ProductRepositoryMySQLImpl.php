<?php

namespace App\repository\impl;


use App\db\Database;
use App\mapper\impl\ProductDetailMapper;
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

    public function getProductById(int $id): object
    {
        $query = "SELECT * FROM product_details WHERE id=" . $id;
        return $this->database->queryOne($query, new ProductDetailMapper());
    }

    public function updateProductDetail(int $productId, string $title, string $author, string $description, string $distributor, int $price, string $imageUrl): bool
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
                $productId
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

    public function deleteProductDetail(int $id): bool
    {
        return $this->database->query(
            "DELETE FROM product_details where id=%d",
            [
                $id
            ]
        );
    }

    public function productExists(int $productId): bool
    {
        return $this->database->countWithQuery("product_details where id=$productId") == 1;
    }
}


