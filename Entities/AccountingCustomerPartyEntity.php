<?php

namespace App\Uyumsoft\Entities;

class AccountingCustomerPartyEntity
{
    private PartyEntity $PartyEntity;

    public function getPartyEntity(): PartyEntity
    {
        return $this->PartyEntity;
    }

    public function setPartyEntity(PartyEntity $PartyEntity): AccountingCustomerPartyEntity
    {
        $this->PartyEntity = $PartyEntity;
        return $this;
    }

    public function getArray(): array
    {
        return [
            'AccountingCustomerParty' => $this->PartyEntity->getArray(),
        ];
    }
}
