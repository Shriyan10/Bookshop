<?php

namespace App\request;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\SerializerBuilder;

class UserCreateRequest{
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $password;
    public int $roleId;
    public string $address;
    public int $contactNo;

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getContactNo(): int
    {
        return $this->contactNo;
    }

    public function setContactNo(int $contactNo): void
    {
        $this->contactNo = $contactNo;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function setRoleId(int $roleId): void
    {
        $this->roleId = $roleId;
    }
}
