<?php

namespace App\Uyumsoft\Entities;

class TaxSchemeEntity
{
    private string $Name;
    private string $TaxTypeCode = "";

    public function getName(): string
    {
        return $this->Name;
    }

    public function setName(string $Name): TaxSchemeEntity
    {
        $this->Name = $Name;
        return $this;
    }

    public function getTaxTypeCode(): string | null
    {
        return $this->TaxTypeCode ?: null;
    }

    public function setTaxTypeCode(string $TaxTypeCode): TaxSchemeEntity
    {
        $this->TaxTypeCode = $TaxTypeCode;
        return $this;
    }

    public function getArray()
    {
        $array = [
            'Name' => [
                'value' => $this->getName(),
            ],
        ];

        if ($this->getTaxTypeCode()) {
            $array['TaxTypeCode'] = [
                'value' => $this->getTaxTypeCode(),
            ];
        }

        return [
            'TaxScheme' => $array
        ];
    }
}
