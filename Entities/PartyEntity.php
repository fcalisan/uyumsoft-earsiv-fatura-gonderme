<?php

namespace App\Uyumsoft\Entities;

class PartyEntity
{
    private string $WebsiteURI = ''; // Zorunlu Alan Değil
    private PartyIdentificationEntity $PartyIdentification;
    private PartyNameEntity $PartyName;
    private ?PostalAddressEntity $PostalAddress = null;
    private PartyTaxSchemeEntity $PartyTaxScheme;
    private ?PersonEntity $Person = null;
    private ?ContactEntity $Contact = null;

    public function getWebsiteURI(): string
    {
        return $this->WebsiteURI;
    }

    public function setWebsiteURI(string $WebsiteURI): PartyEntity
    {
        $this->WebsiteURI = $WebsiteURI;
        return $this;
    }

    public function getPartyIdentification(): PartyIdentificationEntity
    {
        return $this->PartyIdentification;
    }

    public function setPartyIdentification(PartyIdentificationEntity $PartyIdentification): PartyEntity
    {
        $this->PartyIdentification = $PartyIdentification;
        return $this;
    }

    public function getPartyName(): PartyNameEntity
    {
        return $this->PartyName;
    }

    public function setPartyName(PartyNameEntity $PartyName): PartyEntity
    {
        $this->PartyName = $PartyName;
        return $this;
    }

    public function getPostalAddress(): PostalAddressEntity | null
    {
        return $this->PostalAddress ?: null;
    }

    public function setPostalAddress(PostalAddressEntity $PostalAddress): PartyEntity
    {
        $this->PostalAddress = $PostalAddress;
        return $this;
    }

    public function getPartyTaxScheme(): PartyTaxSchemeEntity | null
    {
        return $this->PartyTaxScheme ?: null;
    }

    public function setPartyTaxScheme(PartyTaxSchemeEntity $PartyTaxScheme): PartyEntity
    {
        $this->PartyTaxScheme = $PartyTaxScheme;
        return $this;
    }

    public function getPerson(): PersonEntity | null
    {
        return $this->Person ?: null;
    }

    public function setPerson(PersonEntity $Person): PartyEntity
    {
        $this->Person = $Person;
        return $this;
    }

    public function getContact(): ContactEntity | null
    {
        return $this->Contact ?: null;
    }

    public function setContact(ContactEntity $Contact): PartyEntity
    {
        $this->Contact = $Contact;
        return $this;
    }

    public function getArray()
    {

        $array = [];

        if ($this->getWebsiteURI() !== '') {
            $array['WebsiteURI'] = $this->getWebsiteURI();
        }

        if ($this->getPartyIdentification() !== null) {
            $array = array_merge($array, $this->getPartyIdentification()->getArray());
        }

        if ($this->getPartyName() !== null) {
            $array = array_merge($array, $this->getPartyName()->getArray());
        }

        if ($this->getPostalAddress() !== null) {
            $array = array_merge($array, $this->getPostalAddress()->getArray());
        }

        if ($this->getPartyTaxScheme() !== null) {
            $array = array_merge($array, $this->getPartyTaxScheme()->getArray());
        }

        if ($this->getPerson() !== null) {
            $array = array_merge($array, $this->getPerson()->getArray());
        }

        if ($this->getContact() !== null) {
            $array = array_merge($array, $this->getContact()->getArray());
        }

        return [
            'Party' => $array
        ];
    }
}
