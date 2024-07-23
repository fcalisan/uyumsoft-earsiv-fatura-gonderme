<?php

namespace App\Uyumsoft\Entities;

class LegalMonetaryTotalEntity
{
    private ?TaxAmountEntity $LineExtensionAmount;
    private ?TaxAmountEntity $TaxExclusiveAmount;
    private ?TaxAmountEntity $TaxInclusiveAmount;
    private ?TaxAmountEntity $AllowanceTotalAmount;
    private ?TaxAmountEntity $PayableAmount;


    public function getLineExtensionAmount(): TaxAmountEntity | null
    {
        return $this->LineExtensionAmount ?: null;
    }

    public function setLineExtensionAmount(TaxAmountEntity $LineExtensionAmount): LegalMonetaryTotalEntity
    {
        $this->LineExtensionAmount = $LineExtensionAmount;
        return $this;
    }

    public function getTaxExclusiveAmount(): TaxAmountEntity | null
    {
        return $this->TaxExclusiveAmount ?: null;
    }

    public function setTaxExclusiveAmount(TaxAmountEntity $TaxExclusiveAmount): LegalMonetaryTotalEntity
    {
        $this->TaxExclusiveAmount = $TaxExclusiveAmount;
        return $this;
    }

    public function getTaxInclusiveAmount(): TaxAmountEntity | null
    {
        return $this->TaxInclusiveAmount ?: null;
    }

    public function setTaxInclusiveAmount(TaxAmountEntity $TaxInclusiveAmount): LegalMonetaryTotalEntity
    {
        $this->TaxInclusiveAmount = $TaxInclusiveAmount;
        return $this;
    }

    public function getAllowanceTotalAmount(): TaxAmountEntity | null
    {
        return $this->AllowanceTotalAmount ?: null;
    }

    public function setAllowanceTotalAmount(TaxAmountEntity $AllowanceTotalAmount): LegalMonetaryTotalEntity
    {
        $this->AllowanceTotalAmount = $AllowanceTotalAmount;
        return $this;
    }

    public function getPayableAmount(): TaxAmountEntity | null
    {
        return $this->PayableAmount ?: null;
    }

    public function setPayableAmount(TaxAmountEntity $PayableAmount): LegalMonetaryTotalEntity
    {
        $this->PayableAmount = $PayableAmount;
        return $this;
    }

    public function getArray()
    {
        $array = [];

        if ($this->getLineExtensionAmount()) {
            $array['LineExtensionAmount'] = $this->getLineExtensionAmount()->getArray()['TaxAmount'];
        }

        if ($this->getTaxExclusiveAmount()) {
            $array['TaxExclusiveAmount'] = $this->getTaxExclusiveAmount()->getArray()['TaxAmount'];
        }

        if ($this->getTaxInclusiveAmount()) {
            $array['TaxInclusiveAmount'] = $this->getTaxInclusiveAmount()->getArray()['TaxAmount'];
        }

        if ($this->getAllowanceTotalAmount()) {
            $array['AllowanceTotalAmount'] = $this->getAllowanceTotalAmount()->getArray()['TaxAmount'];
        }

        if ($this->getPayableAmount()) {
            $array['PayableAmount'] = $this->getPayableAmount()->getArray()['TaxAmount'];
        }

        return [
            'LegalMonetaryTotal' => $array
        ];
    }
}
