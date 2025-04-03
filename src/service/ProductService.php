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
    public function getAllProductDetailsDropdown(string $search): array
    {
        try {
            return $this->productRepository->getAllProductDetailsForDropdown($search);
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
            $productDetail = $this->productRepository->getProductDetailById($id);
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
            $productExists = $this->productRepository->productDetailExists($productId);
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
    public function deleteProductDetail(int $id): bool
    {
        try {
            $productExists = $this->productRepository->productDetailExists($id);
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

    /**
     * @throws ApplicationException
     */
    public function statistics(int $id): object
    {
        try {
            $productDetail = $this->productRepository->productDetailStatistics($id);
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
    public function getAllProducts(int $start, int $limit, int $productDetailId,int $productId): object
    {
        try {
            return $this->productRepository->getAllProducts($start, $limit, $productDetailId, $productId);
        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function getProductInventoryById(int $id): object|null
    {
        try {
            $products = $this->productRepository->getProductInventoryById($id);
            if (!$products) {
                throw new ApplicationException("Product not found", 404);
            }
            return $products;
        } catch (ApplicationException $e) {
            throw $e;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new ApplicationException($e);
        }
    }


}