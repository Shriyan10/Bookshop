<?php

namespace App\service;

use App\exception\ApplicationException;
use App\repository\ProductRepository;
use Exception;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @throws ApplicationException
     */
    public function getAllProductDetails(int $start, int $limit, string $search): object
    {
        try {
            return $this->productRepository->getAllProductDetails($start, $limit, $search);
        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function getProductById(int $id): object|null
    {
        try {
            $productDetail = $this->productRepository->getProductById($id);
            if (!$productDetail) {
                throw new ApplicationException("Product Detail not found", 404);
            }
            return $productDetail;
        } catch (ApplicationException $e) {
            throw $e;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function updateProductDetail(int $productId, string $title, string $author, string $description, string $distributor, int $price, string $imageUrl): bool
    {
        try {
            $productExists = $this->productRepository->productExists($productId);
            if (!$productExists) {
                throw new ApplicationException("Product Detail not found", 404);
            }

            return $this->productRepository->updateProductDetail($productId, $title, $author, $description, $distributor, $price, $imageUrl);

        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function saveProductDetail(string $title, string $author, string $description, string $distributor, int $price, string $imageUrl): bool
    {
        try {
            return $this->productRepository->saveProductDetail($title, $author, $description, $distributor, $price, $imageUrl);
        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function deleteProductDetail(int $id)
    {
        try {
            $productExists = $this->productRepository->productExists($id);
            if (!$productExists) {
                throw new ApplicationException("Product Detail not found", 404);
            }

            return $this->productRepository->deleteProductDetail($id);
        } catch (ApplicationException $e) {
            throw $e;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new ApplicationException($e);
        }
    }

}