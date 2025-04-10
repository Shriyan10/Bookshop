<?php

declare(strict_types=1);
namespace App\request;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class CreateProductRequest{

    #[SerializedName('productDetailId')]
    #[Type('int')]
    public int $productDetailId;

    #[SerializedName('quantity')]
    #[Type('int')]
    public int $quantity;

    public function getProductDetailId(): int
    {
        return $this->productDetailId;
    }

    public function setProductDetailId(int $productDetailId): void
    {
        $this->productDetailId = $productDetailId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }



}