<?php

namespace App\model;
class User
{
    public int|null $id;
    public string $firstName;
    public string $lastName;
    public string $email;
    public string|null $password;
    public int|string $roleId;
    public string $address;
    public int $contactNo;

    /**
     * @param int $id
     * @param string $address
     * @param int $contactNo
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $password
     * @param int $roleId
     */
    public function __construct(int|null $id, string $firstName, string $lastName, string $email, string|null $password, int|string $roleId, string $address, int $contactNo)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->roleId = $roleId;
        $this->address = $address;
        $this->contactNo = $contactNo;
    }

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

    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int|null $id): void
    {
        $this->id = $id;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPassword(): string|null
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRoleId(): int|string
    {
        return $this->roleId;
    }

    public function setRoleId(int|string $roleId): void
    {
        $this->roleId = $roleId;
    }


}
