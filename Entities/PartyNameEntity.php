<?php

namespace App\Uyumsoft\Entities;

class PartyNameEntity
{
    private string $Name;

    public function getName(): string
    {
        return $this->Name;
    }

    public function setName(string $Name): PartyNameEntity
    {
        $this->Name = $Name;
        return $this;
    }

    public function getArray()
    {
        return [
            'PartyName' => [
                "Name" => [
                    "value" => $this->Name
                ]
            ]
        ];
    }
}
