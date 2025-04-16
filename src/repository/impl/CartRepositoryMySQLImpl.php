<?php

namespace App\repository\impl;


use App\db\Database;
use App\repository\BaseRepository;
use App\repository\CartRepository;


class CartRepositoryMySQLImpl extends BaseRepository implements CartRepository
{
    public function __construct(Database $database)
    {
        parent::__construct($database);
    }


}


