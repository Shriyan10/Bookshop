<?php

namespace App\repository;

interface ProductOptionRepository
{

    public function getProductOptions(int $id): array|null;

}


