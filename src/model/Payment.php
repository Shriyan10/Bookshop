<?php

namespace App\model;
class Payment
{
    public int|null $id;
    public int $totalCost;
    public int|null $deliveryCharge;
    public int $userId;


    public function __construct(int|null $id, int $totalCost, int|null $deliveryCharge, int $userId)
    {
        $this->id = $id;
        $this->totalCost = $totalCost;
        $this->deliveryCharge = $deliveryCharge;
        $this->userId = $userId;
    }

    public function getDeliveryCharge(): int
    {
        return $this->deliveryCharge;
    }

    public function setDeliveryCharge(int $deliveryCharge): void
    {
        $this->deliveryCharge = $deliveryCharge;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTotalCost(): int
    {
        return $this->totalCost;
    }

    public function setTotalCost(int $totalCost): void
    {
        $this->totalCost = $totalCost;
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
