<?php

namespace App\model;
class User
{
    public int $id;
    public string $firstName;
    public $lastName;
    public $email;
    public $password;
    public $role_id;
    public $address;
    public $contact_no;

    // Constructor
    public function __construct($id, $firstName, $lastName, $email, $password, $role_id, $address, $contact_no)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->role_id = $role_id;
        $this->address = $address;
        $this->contact_no = $contact_no;

    }
}
