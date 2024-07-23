<?php

namespace App\Uyumsoft\Entities;

class InvoiceLineEntity
{
    private int $Id;
    private string $Note;
    private InvoicedQuantityEntity $InvoicedQuantity;
    private TaxAmountEntity $LineExtensionAmount;
    private TaxTotalEntity $TaxTotal;
    private InvoiceLineItemEntity $Item;
    private PriceEntity $Price;

    public function getId(): int
    {
        if ($this->Id == null || $this->Id == 0)
            $this->Id = rand(1, 10000);
        return $this->Id;
    }

    public function setId(int $Id): InvoiceLineEntity
    {
        $this->Id = $Id;
        return $this;
    }

    public function getNote(): string
    {
        return $this->Note;
    }

    public function setNote(string $Note): InvoiceLineEntity
    {
        $this->Note = $Note;
        return $this;
    }

    public function getInvoicedQuantity(): InvoicedQuantityEntity
    {
        return $this->InvoicedQuantity;
    }

    public function setInvoicedQuantity(InvoicedQuantityEntity $InvoicedQuantity): InvoiceLineEntity
    {
        $this->InvoicedQuantity = $InvoicedQuantity;
        return $this;
    }

    public function getLineExtensionAmount(): TaxAmountEntity
    {
        return $this->LineExtensionAmount;
    }

    public function setLineExtensionAmount(TaxAmountEntity $LineExtensionAmount): InvoiceLineEntity
    {
        $this->LineExtensionAmount = $LineExtensionAmount;
        return $this;
    }

    public function getTaxTotal(): TaxTotalEntity
    {
        return $this->TaxTotal;
    }

    public function setTaxTotal(TaxTotalEntity $TaxTotal): InvoiceLineEntity
    {
        $this->TaxTotal = $TaxTotal;
        return $this;
    }

    public function getItem(): InvoiceLineItemEntity
    {
        return $this->Item;
    }

    public function setItem(InvoiceLineItemEntity $Item): InvoiceLineEntity
    {
        $this->Item = $Item;
        return $this;
    }

    public function getPrice(): PriceEntity
    {
        return $this->Price;
    }

    public function setPrice(PriceEntity $Price): InvoiceLineEntity
    {
        $this->Price = $Price;
        return $this;
    }

    public function getArray(): array
    {

        $lineExtensionAmount = $this->getLineExtensionAmount()->getArray()['TaxAmount'];

        return [
            'Id' => [
                'value' => $this->getId(),
            ],
            'Note' => [
                [
                    'value' => $this->getNote(),
                ]
            ],
            ...$this->InvoicedQuantity->getArray(),
            'LineExtensionAmount' => [
                'currencyId' => $lineExtensionAmount['currencyId'],
                'value' => $lineExtensionAmount['value']
            ],
            ...$this->TaxTotal->getArray(),
            ...$this->Item->getArray(),
            ...$this->Price->getArray(),
        ];
    }
}
