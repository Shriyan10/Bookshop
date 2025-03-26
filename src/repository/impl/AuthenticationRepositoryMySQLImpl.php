<?php

namespace App\repository\impl;


use App\db\Database;
use App\mapper\impl\UserMapper;
use App\repository\AuthenticationRepository;
use App\repository\BaseRepository;


class AuthenticationRepositoryMySQLImpl extends BaseRepository implements AuthenticationRepository
{
    public function __construct(Database $database)
    {
        parent::__construct($database);
    }

   public function login(string $email, string $password): object
   {
       $sql = "SELECT u.id, u.first_name, u.last_name, u.email, u.address, u.contact_no, r.name AS role_id, u.password FROM users u JOIN roles r ON u.role_id = r.id WHERE u.email='$email'";

       return $this->database->queryOne($sql, new UserMapper());
   }
}


