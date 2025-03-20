<?php

namespace App\controller\api\admin;

use App\controller\RestController;
use App\exception\ApplicationException;
use App\response\ServerResponse;
use App\service\ProductService;


class ProductRestController extends RestController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @throws ApplicationException
     */
    function getAllProductDetails(): void
    {
        $data = $this->productService->getAllProductDetails(
            $this->getQueryParam("start", 1),
            $this->getQueryParam("limit", 8),
            $this->getQueryParam("search", "")
        );
        $serverResponse = new ServerResponse($data);
        $this->response(200, $serverResponse);
    }

    /**
     * @throws ApplicationException
     */
    function getProductDetails(int $id): void
    {
        $serverResponse = new ServerResponse($this->productService->getProductById($id));
        $this->response(200, $serverResponse);
    }

    /**
     * @throws ApplicationException
     */
    function updateProductDetail(int $productId): void
    {
        $success = $this->productService->updateProductDetail($productId, $this->requestBody()['title'], $this->requestBody()['author'], $this->requestBody()['description'], $this->requestBody()['distributor'], $this->requestBody()['price'], $this->requestBody()['imageUrl']);

        if ($success) {
            $serverResponse = new ServerResponse(null, "Product Detail has been updated");
            $this->response(200, $serverResponse);
        } else {
            throw new ApplicationException("Product Detail update failed", 500);
        }
    }

    /**
     * @throws ApplicationException
     */
    function saveProductDetail(): void
    {
        $success = $this->productService->saveProductDetail($this->requestBody()['title'], $this->requestBody()['author'], $this->requestBody()['description'], $this->requestBody()['distributor'], $this->requestBody()['price'], $this->requestBody()['imageUrl']);

        if ($success) {
            $serverResponse = new ServerResponse(null, "Product Detail has been created");
            $this->response(201, $serverResponse);
        } else {
            throw new ApplicationException("Product Detail creation failed", 500);
        }
    }

    /**
     * @throws ApplicationException
     */
    function deleteProductDetail(int $id): void
    {
        $success = $this->productService->deleteProductDetail($id);

        if ($success) {
            $serverResponse = new ServerResponse(null, "Product Detail has been deleted");
            $this->response(200, $serverResponse);
        } else {
            throw new ApplicationException("Product Detail delete failed", 500);
        }
    }
}