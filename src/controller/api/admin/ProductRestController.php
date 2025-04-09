<?php

namespace App\controller\api\admin;

use App\controller\RestController;
use App\exception\ApplicationException;
use App\response\ServerResponse;
use App\service\ProductService;
use App\util\ObjectMapper;


class ProductRestController extends RestController
{
    private ProductService $productService;

    public function __construct(ProductService $productService, ObjectMapper $objectMapper)
    {
        parent::__construct($objectMapper);
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
    function getAllProductDetailDropdown(): void
    {
        $data = $this->productService->getAllProductDetailsDropdown(
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

    /**
     * @throws ApplicationException
     */
    function statistics(int $productDetailId): void
    {
        $serverResponse = new ServerResponse($this->productService->statistics($productDetailId));
        $this->response(200, $serverResponse);
    }

    /**
     * @throws ApplicationException
     */
    function getAllProducts(): void
    {
        $data = $this->productService->getAllProducts(
            $this->getQueryParam("start", 1),
            $this->getQueryParam("limit", 8),
            $this->getQueryParam("productDetailId", 0),
            $this->getQueryParam("productId", 0)
        );
        $serverResponse = new ServerResponse($data);
        $this->response(200, $serverResponse);
    }

    /**
     * @throws ApplicationException
     */
    function getProductsById(int $id): void
    {
        $serverResponse = new ServerResponse($this->productService->getProductInventoryById($id));
        $this->response(200, $serverResponse);
    }

    /**
     * @throws ApplicationException
     */
    function saveProduct(): void
    {
        $this->productService->saveProduct($this->mandatoryKey('productDetailId'), $this->mandatoryKey('quantity'));
        $serverResponse = new ServerResponse(null, "Product has been saved");
        $this->response(200, $serverResponse);
    }

    /**
     * @throws ApplicationException
     */
    function updateProduct(): void
    {
        $success = $this->productService->updateProduct($this->mandatoryKey('productId'), $this->mandatoryKey('status'));

        if ($success) {
            $serverResponse = new ServerResponse(null, "Product has been updated");
            $this->response(200, $serverResponse);
        } else {
            throw new ApplicationException("Product update failed", 500);
        }
    }

    /**
     * @throws ApplicationException
     */
    function deleteProduct(int $id): void
    {
        $success = $this->productService->deleteProduct($id);

        if ($success) {
            $serverResponse = new ServerResponse(null, "Product has been deleted");
            $this->response(200, $serverResponse);
        } else {
            throw new ApplicationException("Product delete failed", 500);
        }
    }
}