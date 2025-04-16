<?php

namespace App\service;


use App\exception\ApplicationException;
use App\repository\ProductRepository;
use Exception;

class CustomerProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }


    /**
     * @throws ApplicationException
     */
    public function getAllProductDetails(int $start, int $limit, string $search): object
    {
        try {
            return $this->productRepository->getAllProductDetailsQuantityByStatus($start, $limit, $search);
        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function getProductDetail(int $id): object
    {
        try {
            $productDetail = $this->productRepository->getProductDetail($id);
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

}