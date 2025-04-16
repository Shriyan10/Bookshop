<?php

namespace App\controller\api\admin;

use App\controller\api\RestController;
use App\exception\ApplicationException;
use App\request\CreateProductDetailRequest;
use App\request\CreateProductRequest;
use App\request\UpdateProductDetailRequest;
use App\request\UpdateProductRequest;
use App\response\ServerResponse;
use App\service\ProductService;
use App\util\ObjectMapper;
use App\validator\Validator;


class ProductRestController extends RestController
{
    private ProductService $productService;
    private Validator $validator;

    public function __construct(ProductService $productService, ObjectMapper $objectMapper)
    {
        parent::__construct($objectMapper);
        $this->productService = $productService;
        $this->validator = new Validator();
    }

    /**
     * @throws ApplicationException
     */
    function getAllProductDetails(): void
    {
        $data = $this->productService->getAllProductDetails(
            $this->getQueryParamValidated("start", 1, $this->numberValidator("Start")),
            $this->getQueryParamValidated("limit", 8, $this->numberValidator("Limit")),
            $this->getQueryParam("search", "")
        );
        $serverResponse = new ServerResponse($data);
        $this->response(200, $serverResponse);
    }

    function numberValidator(string $type): \Closure
    {
        return $this->validator->numberValidator($type);
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
    function updateProductDetail(): void
    {
        $request = $this->requestModel(UpdateProductDetailRequest::class);
        $success = $this->productService->updateProductDetail($request);

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
        $request = $this->requestModel(CreateProductDetailRequest::class);
        $success = $this->productService->saveProductDetail($request);

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
            $this->getQueryParam("productId", 0),
            $this->getQueryParam("createdDate", "")
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
        $request = $this->requestModel(CreateProductRequest::class);
        $this->productService->saveProduct($request);
        $serverResponse = new ServerResponse(null, "Product has been saved");
        $this->response(200, $serverResponse);
    }

    /**
     * @throws ApplicationException
     */
    function updateProduct(): void
    {

        $request = $this->requestModel(UpdateProductRequest::class);
        $success = $this->productService->updateProduct($request);

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