<?php

declare(strict_types=1);
namespace App\request;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class UpdateRoleRequest{

    #[SerializedName('roleId')]
    #[Type('int')]
    public int $roleId;

    #[SerializedName('name')]
    #[Type('string')]
    public string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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