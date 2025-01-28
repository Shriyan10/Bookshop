<?php

namespace App\db;


class PaginatedResponse
{
    public array $data;
    public int $total;
    public int $size;

    public function __construct(array $data, int $total, int $size)
    {
        $this->data = $data;
        $this->total = $total;
        $this->size = $size;
    }
}