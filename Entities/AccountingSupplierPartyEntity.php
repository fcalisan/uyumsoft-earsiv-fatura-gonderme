<?php

namespace App\Uyumsoft\Entities;

class AccountingSupplierPartyEntity
{
    private PartyEntity $PartyEntity;

    public function getPartyEntity(): PartyEntity
    {
        return $this->PartyEntity;
    }

    public function setPartyEntity(PartyEntity $PartyEntity): AccountingSupplierPartyEntity
    {
        $this->PartyEntity = $PartyEntity;
        return $this;
    }

    public function getArray(): array
    {
        return [
            'AccountingSupplierParty' => $this->PartyEntity->getArray(),
        ];
    }
}
