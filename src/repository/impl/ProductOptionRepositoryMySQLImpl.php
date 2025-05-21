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

        $options = $this->database->queryAll($query, new ProductOptionMapper());

        for ($i = 0; $i < count($options); $i++) {
            if (!$options[$i]->isItem) {
                for ($j = 0; $j < count($options); $j++) {
                    if ($options[$i]->id == $options[$j]->id) {
                        continue;
                    }
                    if ($options[$j]->parentId == $options[$i]->id) {
                        array_push($options[$i]->children, $options[$j]);
                    }
                }
            }
        }

        $response = [];
        foreach ($options as $option) {
            if ($option->parentId == $option->superId) {
                array_push($response, $option);
            }
        }

        return $response;
    }

}




