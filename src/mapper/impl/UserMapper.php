<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\Model\User;

class UserMapper implements RowMapper
{

    public function map($row): User
    {
        return new User(
            $row["id"],
            $row["first_name"],
            $row["last_name"],
            $row["email"],
            $row["password"],
            $row["role"],
            $row["address"],
            $row["contact_no"]
        );
    }
}