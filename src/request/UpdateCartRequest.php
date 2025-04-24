<?php

declare(strict_types=1);
namespace App\request;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class UpdateCartRequest{

    #[SerializedName('productDetailId')]
    #[Type('integer')]
    public int $productDetailId;

    #[SerializedName('quantity')]
    #[Type('integer')]
    public int $quantity;
}