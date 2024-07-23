<?php

namespace App\Uyumsoft\Entities;

class PriceAmountEntity
{
    private string $CurrencyId;
    private float $Value;

    public function __construct()
    {
        $this->CurrencyId = "TRY";
    }

    public function getCurrencyId(): string
    {
        return $this->CurrencyId;
    }

    public function setCurrencyId(string $CurrencyId): PriceAmountEntity
    {
        $this->CurrencyId = $CurrencyId;
        return $this;
    }

    public function getValue(): float
    {
        return $this->Value;
    }

    public function setValue(float $Value): PriceAmountEntity
    {
        $this->Value = $Value;
        return $this;
    }

    public function getArray(): array
    {
        return [
            'PriceAmount' => [
                'currencyId' => $this->getCurrencyId(),
                'value' => $this->getValue()
            ]
        ];
    }
}
