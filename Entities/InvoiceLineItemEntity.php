<?php

namespace App\Uyumsoft\Entities;

class InvoiceLineItemEntity
{
    private string $Description;
    private string $Name;
    private string $ModelName;

    public function __construct()
    {
        $this->Description = '';
        $this->Name = '';
        $this->ModelName = '';
    }


    public function getDescription(): string
    {
        return $this->Description;
    }


    public function setDescription(string $Description): InvoiceLineItemEntity
    {
        $this->Description = $Description;
        return $this;
    }


    public function getName(): string
    {
        return $this->Name;
    }


    public function setName(string $Name): InvoiceLineItemEntity
    {
        $this->Name = $Name;
        return $this;
    }


    public function getModelName(): string
    {
        return $this->ModelName;
    }


    public function setModelName(string $ModelName): InvoiceLineItemEntity
    {
        $this->ModelName = $ModelName;
        return $this;
    }

    public function getArray(): array
    {
        return [
            'Item' => array_map(fn ($item) => ['value' => $item], get_object_vars($this)),
        ];
    }
}
