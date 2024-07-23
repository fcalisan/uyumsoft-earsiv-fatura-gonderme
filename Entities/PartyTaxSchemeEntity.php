<?php

namespace App\Uyumsoft\Entities;

class PartyTaxSchemeEntity
{
    private TaxSchemeEntity $TaxScheme;

    public function getTaxScheme(): TaxSchemeEntity
    {
        return $this->TaxScheme;
    }

    public function setTaxScheme(TaxSchemeEntity $TaxScheme): PartyTaxSchemeEntity
    {
        $this->TaxScheme = $TaxScheme;
        return $this;
    }

    public function getArray()
    {
        return [
            'PartyTaxScheme' => $this->getTaxScheme()->getArray()
        ];
    }
}
