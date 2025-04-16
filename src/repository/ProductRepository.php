<?php

namespace App\repository;

interface ProductRepository {

    public function getAllProductDetails(int $start, int $limit, string $search): object;

    public function getAllProductDetailsQuantityByStatus(int $start, int $limit, string $search): object;

    public function getProductDetailById(int $productDetailId): object|null;

    public function updateProductDetail(int $productDetailId, string $title, string $author, string $description, string $distributor, int $price, string $imageUrl): bool;

    public function saveProductDetail(string $title, string $author, string $description, string $distributor, int $price, string $imageUrl): bool;

    public function deleteProductDetail(int $productDetailId): bool;

    public function productDetailExists(int $productDetailId): bool;

    public function productDetailStatistics(int $productDetailId): object|null;

    public function getAllProducts(int $start, int $limit, int $productDetailId, int $productId, string $createdDate): object;

    public function getProductInventoryById(int $id);

    public function getAllProductDetailsForDropdown(string $search): array;

    public function saveProduct(\mysqli $connection, int $productDetailId):bool;

    public function updateProduct(int $id, string $status): bool;

    public function deleteProduct(int $id): bool;

    public function productExists(int $productId): bool;

    public function getProductDetail(int $id);
}


