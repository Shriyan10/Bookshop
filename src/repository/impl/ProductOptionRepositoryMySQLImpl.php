<?php

namespace App\repository\impl;


use App\db\Database;
use App\mapper\impl\ProductOptionMapper;
use App\repository\BaseRepository;
use App\repository\ProductOptionRepository;
use Exception;

class ProductOptionRepositoryMySQLImpl extends BaseRepository implements ProductOptionRepository
{
    public function __construct(Database $database)
    {
        parent::__construct($database);
    }

    /**
     * @throws Exception
     */
    public function getProductOptions(int $id): array|null
    {
        $query = "SELECT * FROM product_details WHERE super_id = $id";

        return $this->database->queryAll($query, new ProductOptionMapper());
    }

}




