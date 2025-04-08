<?php

namespace App\validator;

class AttributeValidator
{
    private string $name;
    private string $type;
    private array $validators;
    private array $innerAttributes;

    public function __construct(string $name, string $type, array $validators = [], array $innerAttributes = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->validators = $validators;
        $this->innerAttributes = $innerAttributes;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValidators(): array
    {
        return $this->validators;
    }

    /**
     * @return AttributeValidator[]
     */
    public function getInnerAttributes(): array
    {
        return $this->innerAttributes;
    }
}