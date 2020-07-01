<?php


namespace Lukeraymonddowning\PostcodeLookup\Address;


class SimpleAddress implements AddressInterface
{
    protected ?string $line1, $city, $postalCode, $country, $line2, $county;

    public static function create()
    {
        return new self();
    }

    public function line1(): ?string
    {
        return $this->line1;
    }

    public function line2(): ?string
    {
        return $this->line2;
    }

    public function city(): ?string
    {
        return $this->city;
    }

    public function county(): ?string
    {
        return $this->county;
    }

    public function postalCode(): ?string
    {
        return $this->postalCode;
    }

    public function country(): ?string
    {
        return $this->country;
    }

    public function setLine1(?string $line1): SimpleAddress
    {
        $this->line1 = $line1;
        return $this;
    }

    public function setCity(?string $city): SimpleAddress
    {
        $this->city = $city;
        return $this;
    }

    public function setPostalCode(?string $postalCode): SimpleAddress
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function setCountry(?string $country): SimpleAddress
    {
        $this->country = $country;
        return $this;
    }

    public function setLine2(?string $line2): SimpleAddress
    {
        $this->line2 = $line2;
        return $this;
    }

    public function setCounty(?string $county): SimpleAddress
    {
        $this->county = $county;
        return $this;
    }
}
