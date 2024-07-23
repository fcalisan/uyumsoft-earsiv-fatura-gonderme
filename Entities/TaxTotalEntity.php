<?php

namespace App\Uyumsoft\Entities;

class TaxTotalEntity
{
    private TaxAmountEntity $TaxAmount;
    private array $TaxSubTotal; // TaxSubtotalEntity


    public function getTaxAmount(): TaxAmountEntity
    {
        return $this->TaxAmount;
    }

    public function setTaxAmount(TaxAmountEntity $TaxAmount): TaxTotalEntity
    {
        $this->TaxAmount = $TaxAmount;
        return $this;
    }

    public function getTaxSubTotal(): array
    {
        return $this->TaxSubTotal;
    }

    public function setTaxSubTotal(array $TaxSubTotal): TaxTotalEntity
    {
        $this->TaxSubTotal = $TaxSubTotal;
        return $this;
    }

    public function getArray(): array
    {

        return [
            'TaxTotal' => [
                ...$this->getTaxAmount()->getArray(),
                'TaxSubtotal' => array_map(fn ($item) => $item->getArray(), $this->getTaxSubTotal())
            ]
        ];
    }
}
