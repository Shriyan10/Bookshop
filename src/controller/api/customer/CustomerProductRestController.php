<?php

namespace App\controller\api\customer;

use App\controller\RestController;
use App\exception\ApplicationException;
use App\response\ServerResponse;
use App\service\CustomerProductService;
use App\util\ObjectMapper;


class CustomerProductRestController extends RestController
{
    private CustomerProductService $customerProductService;

    public function __construct(CustomerProductService $customerProductService, ObjectMapper $objectMapper)
    {
        parent::__construct($objectMapper);
        $this->customerProductService = $customerProductService;
    }

    /**
     * @throws ApplicationException
     */
    function getAllProductDetails(): void
    {
        $data = $this->customerProductService->getAllProductDetails(
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
    function getProductDetail(int $id): void
    {
        $serverResponse = new ServerResponse($this->customerProductService->getProductDetail($id));
        $this->response(200, $serverResponse);
    }

}