<?php

namespace App\Uyumsoft\Entities;

class ContactEntity
{
    private string $Telephone = "";

    public function getTelephone(): string
    {
        return $this->Telephone ?? '';
    }

    public function setTelephone(string $Telephone): ContactEntity
    {
        $this->Telephone = $Telephone;
        return $this;
    }


    public function getArray(): array
    {
        return [
            'Contact' => [
                'Telephone' => [
                    'value' => $this->getTelephone(),
                ],
            ]
        ];
    }
}
