<?php

namespace App\model;

class Role
{
    public int|null $id;
    public string $name;

    /**
     * @param int|null $id
     * @param string $name
     */
    public function __construct(int|null $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }


}

