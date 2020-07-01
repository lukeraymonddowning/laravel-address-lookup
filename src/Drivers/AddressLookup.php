<?php


namespace Lukeraymonddowning\PostcodeLookup\Drivers;


use Illuminate\Support\Collection;
use Lukeraymonddowning\PostcodeLookup\Address\AddressInterface;
use Lukeraymonddowning\PostcodeLookup\Exceptions\AddressLookupFailed;

interface AddressLookup
{

    /**
     * @param string $query The query to search for
     * @return Collection<AddressInterface> All matches retrieved from the given query
     * @throws AddressLookupFailed
     */
    public function lookup(string $query): Collection;

}
