<?php

namespace App\mapper\impl;

use App\mapper\RowMapper;
use App\Model\Role;

class RoleMapper implements RowMapper {

    public function map($row)
    {
        return new Role(
            $row["id"],
            $row["name"]
        );
    }
}