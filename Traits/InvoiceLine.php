<?php

namespace App\Uyumsoft\Traits;

use App\Uyumsoft\Entities\InvoiceLineEntity;
use App\Uyumsoft\Entities\InvoiceLineItemEntity;

trait InvoiceLine
{
    private array $InvoiceLines;

    public function setInvoiceLines(array $InvoiceLines): self
    {
        $this->InvoiceLines = $InvoiceLines;
        return $this;
    }

    public function getInvoiceLines(): array
    {
        return $this->InvoiceLines;
    }

    public function getInvoiceLineCount(): int
    {
        return count($this->InvoiceLines);
    }

    public function addInvoiceLine(InvoiceLineEntity $entity): self
    {
        $this->InvoiceLines[] = $entity->getArray();
        return $this;
    }

    public function addInvoiceLines(array $invoiceLines)
    {
        foreach ($invoiceLines as $invoiceLine) {
            $this->addInvoiceLine($invoiceLine);
        }
    }
}
