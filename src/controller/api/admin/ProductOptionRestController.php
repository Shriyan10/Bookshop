<?php

namespace App\controller\api\admin;

use App\controller\api\RestController;
use App\exception\ApplicationException;
use App\response\ServerResponse;
use App\service\ProductOptionService;
use App\util\ObjectMapper;


class ProductOptionRestController extends RestController
{
    private ProductOptionService $productOptionService;

    public function __construct(ProductOptionService $productOptionService, ObjectMapper $objectMapper)
    {
        parent::__construct($objectMapper);
        $this->productOptionService = $productOptionService;
    }

    /**
     * @throws ApplicationException
     */
    function getProductOptions(int $id): void
    {
        $serverResponse = new ServerResponse($this->productOptionService->getProductOptions($id));
        $this->response(200, $serverResponse);
    }

}