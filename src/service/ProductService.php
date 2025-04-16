<?php

namespace App\service;

use App\exception\ApplicationException;
use App\repository\ProductRepository;
use App\request\CreateProductDetailRequest;
use App\request\CreateProductRequest;
use App\request\UpdateProductDetailRequest;
use App\request\UpdateProductRequest;
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
    public function updateProductDetail(UpdateProductDetailRequest $request): bool
    {
        try {
            $productExists = $this->productRepository->productDetailExists($request->productDetailId);
            if (!$productExists) {
                throw new ApplicationException("Product Detail not found", 404);
            }

            return $this->productRepository->updateProductDetail($request->productDetailId, $request->title, $request->author, $request->description, $request->distributor, $request->price, $request->imageUrl);

        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function saveProductDetail(CreateProductDetailRequest $request): bool
    {
        try {
            return $this->productRepository->saveProductDetail(
                $request->title,
                $request->description,
                $request->price,
                $request->imageUrl
            );
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
    public function getAllProducts(int $start, int $limit, int $productDetailId, int $productId, string $createdDate): object
    {
        try {
            return $this->productRepository->getAllProducts($start, $limit, $productDetailId, $productId, $createdDate);
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

    /**
     * @throws ApplicationException
     */
    public function saveProduct(CreateProductRequest $request): void
    {
        try {
            $task = function ($connection) use ($request) {
                for ($i = 0; $i < $request->quantity; $i++) {
                    $this->productRepository->saveProduct($connection, $request->productDetailId);
                }
            };

            $this->productRepository->database->transactionalQuery($task);

        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new ApplicationException("Product save failed", 500);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function updateProduct(UpdateProductRequest $request): bool
    {
        try {
            $productExists = $this->productRepository->productExists($request->productId);
            if (!$productExists) {
                throw new ApplicationException("Product not found", 404);
            }

            return $this->productRepository->updateProduct($request->productId, $request->status);

        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function deleteProduct(int $id): bool
    {
        try {
            $productExists = $this->productRepository->productExists($id);
            if (!$productExists) {
                throw new ApplicationException("Product not found", 404);
            }

            return $this->productRepository->deleteProduct($id);
        } catch (ApplicationException $e) {
            throw $e;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new ApplicationException($e);
        }
    }
}