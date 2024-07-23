<?php

namespace App\Uyumsoft\Entities;

class IdEntity
{
    private string $SchemeId; // Default TCKN
    private String $Value;

    public function getSchemeId(): string
    {
        return $this->SchemeId ? $this->SchemeId : 'TCKN';
    }

    public function getValue(): string
    {
        return $this->Value;
    }

    public function setSchemeId(string $SchemeId): IdEntity
    {
        $this->SchemeId = $SchemeId;
        return $this;
    }

    public function setValue(string $Value): IdEntity
    {
        $this->Value = $Value;
        return $this;
    }

    public function getArray()
    {
        return [
            'Id' => [
                'SchemeId' => $this->getSchemeId(),
                'Value' => $this->getValue()
            ],
        ];
    }
}
