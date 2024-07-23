<?php

namespace App\Uyumsoft\Entities;

class TaxSubTotalEntity
{

    private TaxAmountEntity $TaxableAmount;
    private TaxAmountEntity $TaxAmount;
    private float $Percent;
    private TaxCategoryEntity $TaxCategory;



    public function getTaxableAmount(): TaxAmountEntity
    {
        return $this->TaxableAmount;
    }


    public function setTaxableAmount(TaxAmountEntity $TaxableAmount): TaxSubTotalEntity
    {
        $this->TaxableAmount = $TaxableAmount;
        return $this;
    }


    public function getTaxAmount(): TaxAmountEntity
    {
        return $this->TaxAmount;
    }

    public function setTaxAmount(TaxAmountEntity $TaxAmount): TaxSubTotalEntity
    {
        $this->TaxAmount = $TaxAmount;
        return $this;
    }


    public function getPercent(): float
    {
        return $this->Percent;
    }


    public function setPercent(float $Percent): TaxSubTotalEntity
    {
        $this->Percent = $Percent;
        return $this;
    }


    public function getTaxCategory(): TaxCategoryEntity
    {
        return $this->TaxCategory;
    }


    public function setTaxCategory(TaxCategoryEntity $TaxCategory): TaxSubTotalEntity
    {
        $this->TaxCategory = $TaxCategory;
        return $this;
    }

    public function getArray(): array
    {
        $taxableAmount = $this->getTaxableAmount()->getArray()['TaxAmount'];


        return [
            'TaxableAmount' => [
                'currencyId' => $taxableAmount['currencyId'],
                'value' => $taxableAmount['value']
            ],
            ...$this->getTaxAmount()->getArray(),
            'Percent' => [
                'value' => $this->getPercent()
            ],
            ...$this->getTaxCategory()->getArray()
        ];
    }
}
