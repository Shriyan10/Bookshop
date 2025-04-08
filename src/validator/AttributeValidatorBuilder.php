<?php

namespace App\validator;

class AttributeValidatorBuilder
{
    private string $name;
    private string $type;
    private array $validators = [];
    private array $innerAttributes = [];

    public static function create(): self
    {
        return new self();
    }

    public function withName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function withType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function addValidator(callable $validator): self
    {
        $this->validators[] = $validator;
        return $this;
    }

    public function addValidators(array $validators): self
    {
        $this->validators = array_merge($this->validators, $validators);
        return $this;
    }

    public function addInnerAttribute(AttributeValidator $attribute): self
    {
        $this->innerAttributes[] = $attribute;
        return $this;
    }

    public function addInnerAttributes(array $attributes): self
    {
        $this->innerAttributes = array_merge($this->innerAttributes, $attributes);
        return $this;
    }

    public function build(): AttributeValidator
    {
        return new AttributeValidator(
            $this->name,
            $this->type,
            $this->validators,
            $this->innerAttributes
        );
    }
}