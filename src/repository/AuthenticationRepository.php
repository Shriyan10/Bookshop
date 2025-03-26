<?php

namespace App\repository;

interface AuthenticationRepository {


    public function login(string $email, string $password);
}


