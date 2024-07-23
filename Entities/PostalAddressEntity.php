<?php

namespace App\Uyumsoft\Entities;

class PostalAddressEntity
{
    private string $Room = "";
    private string $StreetName = "";
    private string $BuildingNumber = "";
    private string $CitySubdivisionName = "";
    private string $CityName = "";
    private string $Country = "";

    public function getRoom(): string
    {
        return $this->Room;
    }

    public function getStreetName(): string
    {
        return $this->StreetName;
    }

    public function getBuildingNumber(): string
    {
        return $this->BuildingNumber;
    }

    public function getCitySubdivisionName(): string
    {
        return $this->CitySubdivisionName;
    }

    public function getCityName(): string
    {
        return $this->CityName;
    }

    public function getCountry(): string
    {
        return $this->Country;
    }

    public function setRoom(string $Room): PostalAddressEntity
    {
        $this->Room = $Room;
        return $this;
    }

    public function setStreetName(string $StreetName): PostalAddressEntity
    {
        $this->StreetName = $StreetName;
        return $this;
    }

    public function setBuildingNumber(string $BuildingNumber): PostalAddressEntity
    {
        $this->BuildingNumber = $BuildingNumber;
        return $this;
    }

    public function setCitySubdivisionName(string $CitySubdivisionName): PostalAddressEntity
    {
        $this->CitySubdivisionName = $CitySubdivisionName;
        return $this;
    }

    public function setCityName(string $CityName): PostalAddressEntity
    {
        $this->CityName = $CityName;
        return $this;
    }

    public function setCountry(string $Country): PostalAddressEntity
    {
        $this->Country = $Country;
        return $this;
    }

    public function getArray()
    {
        return [
            'PostalAddress' => [
                'Room' => [
                    'value' => $this->Room ?? ""
                ],
                'StreetName' => [
                    'value' => $this->StreetName
                ],
                'BuildingNumber' => [
                    'value' => $this->BuildingNumber
                ],
                'CitySubdivisionName' => [
                    'value' => $this->CitySubdivisionName
                ],
                'CityName' => [
                    'value' => $this->CityName
                ],
                'Country' => [
                    'Name' => [
                        'value' => $this->Country
                    ],
                ],
            ]
        ];
    }
}
