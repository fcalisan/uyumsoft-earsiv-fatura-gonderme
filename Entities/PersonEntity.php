<?php

namespace App\Uyumsoft\Entities;

class PersonEntity
{
    private string $FirstName;
    private string $FamilyName;

    public function getFirstName(): string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): PersonEntity
    {
        $this->FirstName = $FirstName;
        return $this;
    }

    public function getFamilyName(): string
    {
        return $this->FamilyName;
    }

    public function setFamilyName(string $FamilyName): PersonEntity
    {
        $this->FamilyName = $FamilyName;
        return $this;
    }

    public function getArray()
    {
        return [
            'Person' => [
                'FirstName' => [
                    'value' => $this->getFirstName()
                ],
                'FamilyName' => [
                    'value' => $this->getFamilyName()
                ]
            ]
        ];
    }
}
