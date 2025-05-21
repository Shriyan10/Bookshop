<?php

namespace App\response;


class OptionResponse
{
    public int $id;

    public string $name;


    public int $parentId;
    public bool $isItem;
    public int $superId;
    public array|null $children;



    public function __construct(int $id, string $name, int $parentId, bool $isItem, int $superId, array|null $children){
        $this->id = $id;
        $this->name = $name;
        $this->parentId = $parentId;
        $this->isItem = $isItem;
        $this->superId = $superId;
        $this->children = $children;
    }
}