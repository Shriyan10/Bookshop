<?php

namespace App\repository;

interface ProductRepository {

    public function getAllProductDetails(int $start, int $limit, string $search): object;

    public function getProductById(int $id): object|null;

    public function updateProductDetail(int $productId, string $title, string $author, string $description, string $distributor, int $price, string $imageUrl): bool;

    public function saveProductDetail(string $title, string $author, string $description, string $distributor, int $price, string $imageUrl): bool;

    public function deleteProductDetail(int $id): bool;

    public function productExists(int $productId): bool;
}


