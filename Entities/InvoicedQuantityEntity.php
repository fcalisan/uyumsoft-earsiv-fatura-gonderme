<?php

namespace App\Uyumsoft\Entities;

class InvoicedQuantityEntity
{
    private string $UnitCode; // Default NIU => Adet
    private float $Value; // Default 1

    public function __construct()
    {
        $this->UnitCode = 'NIU';
        $this->Value = 1;
    }

    public function getUnitCode(): string
    {
        return $this->UnitCode;
    }

    public function setUnitCode(string $UnitCode): InvoicedQuantityEntity
    {
        $this->UnitCode = $UnitCode;
        return $this;
    }

    public function getValue(): float
    {
        return $this->Value;
    }

    public function setValue(float $Value): InvoicedQuantityEntity
    {
        $this->Value = $Value;
        return $this;
    }

    public function getArray(): array
    {
        return [
            'InvoicedQuantity' => [
                'unitCode' => $this->UnitCode,
                'value' => $this->Value
            ]
        ];
    }
}
