<?php


namespace Lukeraymonddowning\PostcodeLookup\Address;


interface AddressInterface
{
    public function line1(): ?string;

    public function line2(): ?string;

    public function city(): ?string;

    public function county(): ?string;

    public function postalCode(): ?string;

    public function country(): ?string;
}
