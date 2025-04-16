<?php

namespace App\db;


class PaginatedResponse
{
    public array $items;
    public int $total;
    public int $size;

    public function __construct(array $data, int $total, int $size)
    {
        $this->items = $data;
        $this->total = $total;
        $this->size = $size;
    }
}