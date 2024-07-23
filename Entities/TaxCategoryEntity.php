<?php

namespace App\Uyumsoft\Entities;

class TaxCategoryEntity
{
    private TaxSchemeEntity $TaxScheme;

    public function getTaxScheme(): TaxSchemeEntity
    {
        return $this->TaxScheme;
    }

    public function setTaxScheme(TaxSchemeEntity $TaxScheme): TaxCategoryEntity
    {
        $this->TaxScheme = $TaxScheme;
        return $this;
    }

    public function getArray(): array
    {
        return [
            'TaxCategory' => $this->getTaxScheme()->getArray(),
        ];
    }
}
