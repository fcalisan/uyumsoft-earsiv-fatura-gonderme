<?php

namespace App\Uyumsoft\Entities;

class TaxAmountEntity
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

    public function setCurrencyId(string $CurrencyId): TaxAmountEntity
    {
        $this->CurrencyId = $CurrencyId;
        return $this;
    }

    public function getValue(): float
    {
        return $this->Value;
    }

    public function setValue(float $Value): TaxAmountEntity
    {
        $this->Value = $Value;
        return $this;
    }

    public function getArray(): array
    {
        return [
            'TaxAmount' => [
                'currencyId' => $this->getCurrencyId(),
                'value' => $this->getValue()
            ]
        ];
    }
}
