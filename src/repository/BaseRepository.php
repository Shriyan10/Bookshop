<?php

namespace App\repository;


use App\db\Database;


class BaseRepository
{
    protected Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }
}