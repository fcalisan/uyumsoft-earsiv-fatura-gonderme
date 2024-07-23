<?php

namespace App\Uyumsoft\Entities;

class PartyIdentificationEntity
{
    private array $IdEntities;

    public function getIdEntities(): array
    {
        return $this->IdEntities;
    }

    public function setIdEntities(array $IdEntities): void
    {
        $this->IdEntities = $IdEntities;
    }

    public function addIdEntity(IdEntity $IdEntity): void
    {
        $this->IdEntities[] = $IdEntity;
    }

    public function removeIdEntity(IdEntity $IdEntity): void
    {
        $key = array_search($IdEntity, $this->IdEntities, true);
        if ($key !== false) {
            unset($this->IdEntities[$key]);
        }
    }

    public function hasIdEntity(IdEntity $IdEntity): bool
    {
        return in_array($IdEntity, $this->IdEntities, true);
    }

    public function countIdEntities(): int
    {
        return count($this->IdEntities);
    }

    public function getArray()
    {
        return [
            'PartyIdentification' => array_map(function ($item) {
                return $item->getArray();
            }, $this->getIdEntities())
        ];
    }
}
