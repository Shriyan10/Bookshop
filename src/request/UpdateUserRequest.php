<?php

declare(strict_types=1);
namespace App\request;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class UpdateUserRequest{

    #[SerializedName('userId')]
    #[Type('int')]
    public int $userId;

    #[SerializedName('firstName')]
    #[Type('string')]
    public string $firstName;

    #[SerializedName('lastName')]
    #[Type('string')]
    public string $lastName;

    #[SerializedName('email')]
    #[Type('string')]
    public string $email;

    #[SerializedName('password')]
    #[Type('string')]
    public string $password;

    #[SerializedName('address')]
    #[Type('string')]
    public string $address;

    #[SerializedName('contactNo')]
    #[Type('int')]
    public int $contactNo;

    #[SerializedName('roleId')]
    #[Type('int')]
    public int $roleId;

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

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }



}