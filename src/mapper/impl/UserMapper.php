<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\model\User;

class UserMapper implements RowMapper
{

    public function map($row): User
    {
        return new User(
            $row["id"],
            $row["first_name"],
            $row["last_name"],
            $row["email"],
            $row["password"] ?? null,
            $row["role_id"],
            $row["address"],
            $row["contact_no"]
        );
    }
}