<?php

namespace App\Uyumsoft\Entities;

class PriceEntity
{
    private PriceAmountEntity $PriceAmount;

    public function getPriceAmount(): PriceAmountEntity
    {
        return $this->PriceAmount;
    }

    public function setPriceAmount(PriceAmountEntity $PriceAmount): PriceEntity
    {
        $this->PriceAmount = $PriceAmount;
        return $this;
    }

    public function getArray(): array
    {
        return [
            'Price' => [
                ...$this->getPriceAmount()->getArray()
            ]
        ];
    }
}
