<?php

namespace App\service;

use App\exception\ApplicationException;
use App\repository\ProductOptionRepository;
use Exception;

class ProductOptionService
{
    private ProductOptionRepository $productOptionRepository;

    public function __construct(ProductOptionRepository $productOptionRepository)
    {
        $this->productOptionRepository = $productOptionRepository;
    }

    /**
     * @throws ApplicationException
     */
    public function getProductOptions(int $id): array|null
    {
        try {
            return $this->productOptionRepository->getProductOptions($id);
        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }
}