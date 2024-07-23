<?php

namespace App\Uyumsoft\Entities;

use App\Uyumsoft\Traits\InvoiceLine;
use App\Uyumsoft\Traits\NoteLine;

class InvoiceEntity
{

    use NoteLine;
    use InvoiceLine;

    private float $UblVersionId;
    private string $CustomizationId;
    private string $ProfileId; // EARSIVFATURA, TICARIFATURA
    private bool $CopyIndicator;
    private string $IssueDate;
    private string $IssueTime;
    private string $InvoiceTypeCode;
    private string $DocumentCurrencyCode; // TRY, USD, EUR | Default TRY
    private int $LineCountNumeric; // Invoice Item Count
    private AccountingSupplierPartyEntity $AccountingSupplierParty;
    private AccountingCustomerPartyEntity $AccountingCustomerParty;
    private LegalMonetaryTotalEntity $LegalMonetaryTotal;
    private TaxTotalEntity $TaxTotal;
    private string $LocalDocumentId; // Sistemde tutulan fatura veya order id

    public function __construct()
    {
        $this->UblVersionId = 2.1;
        $this->CustomizationId = "TR1.2";
        $this->ProfileId = "EARSIVFATURA"; // e-Fatura mükellefi değilse fatura EARSIVFATURA, e-Fatura mükellefi ise TICARIFATURA
        $this->CopyIndicator = false;
        $this->IssueDate = date("Y-m-d");
        $this->IssueTime = date("H:i:s");
        $this->InvoiceTypeCode = "SATIS";
        $this->NoteLines = [];
        $this->InvoiceLines = [];
        $this->DocumentCurrencyCode = "TRY";
    }

    public function setUblVersionId(float $UblVersionId): InvoiceEntity
    {
        $this->UblVersionId = $UblVersionId;
        return $this;
    }

    public function getUblVersionId(): float
    {
        return $this->UblVersionId;
    }

    public function setCustomizationId(string $CustomizationId): InvoiceEntity
    {
        $this->CustomizationId = $CustomizationId;
        return $this;
    }

    public function getCustomizationId(): string
    {
        return $this->CustomizationId;
    }

    public function setProfileId(string $ProfileId): InvoiceEntity
    {
        $this->ProfileId = $ProfileId;
        return $this;
    }

    public function getProfileId(): string
    {
        return $this->ProfileId;
    }

    public function setCopyIndicator(bool $CopyIndicator): InvoiceEntity
    {
        $this->CopyIndicator = $CopyIndicator;
        return $this;
    }

    public function getCopyIndicator(): bool
    {
        return $this->CopyIndicator;
    }

    public function setIssueDate(string $IssueDate): InvoiceEntity
    {
        $this->IssueDate = $IssueDate;
        return $this;
    }

    public function getIssueDate(): string
    {
        return $this->IssueDate;
    }

    public function setIssueTime(string $IssueTime): InvoiceEntity
    {
        $this->IssueTime = $IssueTime;
        return $this;
    }

    public function getIssueTime(): string
    {
        return $this->IssueTime;
    }

    public function setInvoiceTypeCode(string $InvoiceTypeCode): InvoiceEntity
    {
        $this->InvoiceTypeCode = $InvoiceTypeCode;
        return $this;
    }

    public function getInvoiceTypeCode(): string
    {
        return $this->InvoiceTypeCode;
    }

    public function setDocumentCurrencyCode(string $DocumentCurrencyCode): InvoiceEntity
    {
        $this->DocumentCurrencyCode = $DocumentCurrencyCode;
        return $this;
    }

    public function getDocumentCurrencyCode(): string
    {
        return $this->DocumentCurrencyCode;
    }

    public function setLineCountNumeric(int $LineCountNumeric): InvoiceEntity
    {
        $this->LineCountNumeric = $LineCountNumeric;
        return $this;
    }

    public function getLineCountNumeric(): int
    {
        return $this->LineCountNumeric || count($this->InvoiceLines); // Veya InvoiceLine Count alınacak
    }

    public function setAccountingSupplierParty(AccountingSupplierPartyEntity $AccountingSupplierParty): InvoiceEntity
    {
        $this->AccountingSupplierParty = $AccountingSupplierParty;
        return $this;
    }

    public function getAccountingSupplierParty(): AccountingSupplierPartyEntity
    {
        return $this->AccountingSupplierParty;
    }

    public function setAccountingCustomerParty(AccountingCustomerPartyEntity $AccountingCustomerParty): InvoiceEntity
    {
        $this->AccountingCustomerParty = $AccountingCustomerParty;
        return $this;
    }

    public function getAccountingCustomerParty(): AccountingCustomerPartyEntity
    {
        return $this->AccountingCustomerParty;
    }

    public function setLegalMonetaryTotal(LegalMonetaryTotalEntity $LegalMonetaryTotal): InvoiceEntity
    {
        $this->LegalMonetaryTotal = $LegalMonetaryTotal;
        return $this;
    }

    public function getLegalMonetaryTotal(): LegalMonetaryTotalEntity | null
    {
        return $this->LegalMonetaryTotal ?: null;
    }

    public function setLocalDocumentId(string $LocalDocumentId): InvoiceEntity
    {
        $this->LocalDocumentId = $LocalDocumentId;
        return $this;
    }

    public function getLocalDocumentId(): string
    {
        return $this->LocalDocumentId;
    }


    public function setTaxTotal(TaxTotalEntity $TaxTotal): InvoiceEntity
    {
        $this->TaxTotal = $TaxTotal;
        return $this;
    }

    public function getTaxTotal(): TaxTotalEntity
    {
        return $this->TaxTotal;
    }


    public function getArray(): array
    {
        $array = [
            'UblVersionId' => [
                'value' => $this->getUblVersionId(),
            ],
            'CustomizationId' => [
                'value' => $this->getCustomizationId(),
            ],
            'ProfileId' => [
                'value' => $this->getProfileId(),
            ],
            'CopyIndicator' => [
                'value' => $this->getCopyIndicator(),
            ],
            'IssueDate' => [
                'value' => $this->getIssueDate()
            ],
            'IssueTime' => [
                'value' => $this->getIssueTime(),
            ],
            'InvoiceTypeCode' => [
                'value' => $this->getInvoiceTypeCode(),
            ],
            'Note' => $this->getNoteLines(),
            'DocumentCurrencyCode' => [
                'value' => $this->getDocumentCurrencyCode(),
            ],
            'LineCountNumeric' => [
                'value' => $this->getLineCountNumeric(),
            ],
            ...$this->getAccountingSupplierParty()->getArray(),
            ...$this->getAccountingCustomerParty()->getArray(),
            ...$this->getLegalMonetaryTotal() ? $this->getLegalMonetaryTotal()->getArray() : null,
            'InvoiceLine' => $this->getInvoiceLines(),
            'TaxTotal' => array_values($this->getTaxTotal()->getArray()),
        ];



        return [
            'invoices' => [
                [
                    'Invoice' => $array
                ]
            ]
        ];
    }
}
