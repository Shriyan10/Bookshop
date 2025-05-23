<?php

namespace App\repository;

interface ProductRepository
{

    public function getAllProductDetails(int $start, int $limit, string $search): object;

    public function getAllProductDetailsQuantityByStatus(int $start, int $limit, string $search): object;

    public function getProductDetailById(int $productDetailId): object|null;

    public function updateProductDetail(int $productDetailId, string $title, string $description, int $price, string $imageUrl, int $parentId, bool $isItem, int $superId): bool;

    public function saveProductDetail(string $title, string $description, int $price, string $imageUrl,  int $parentId, bool $isItem, int $superId): bool;

    public function deleteProductDetail(int $productDetailId): bool;

    public function productDetailExists(int $productDetailId): bool;

    public function productDetailStatistics(int $productDetailId): object|null;

    public function getAllProducts(int $start, int $limit, int $productDetailId, int $productId, string $createdDate): object;

    public function getProductInventoryById(int $id);

    public function getAllProductDetailsForDropdown(string $search): array;

    public function saveProduct(\mysqli $connection, int $productDetailId): int;

    public function updateProduct(int $productId, string $status): bool;

    public function deleteProduct(int $id): bool;

    public function productExists(int $productId): bool;

    public function getProductDetail(int $id): object|null;

    public function getAvailableProductByProductDetailIdAndQuantity(int $productDetailId, int $quantity): array;
}


