<?php


namespace Lukeraymonddowning\PostcodeLookup\Drivers;


use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Lukeraymonddowning\PostcodeLookup\Address\SimpleAddress;
use Lukeraymonddowning\PostcodeLookup\Exceptions\AddressLookupFailed;

class AlgoliaAddressLookup implements AddressLookup
{
    protected const HOSTS = [
        'https://places-dsn.algolia.net',
        'https://places-1.algolianet.com',
        'https://places-2.algolianet.com',
        'https://places-3.algolianet.com'
    ];

    public function lookup(string $query): Collection
    {
        $result = Http::withHeaders($this->getHeaders())->post($this->getHost(), compact('query'));

        $hits = $this->validateResultOrFail($result);

        return collect($hits)->map(function($hit) {
            return SimpleAddress::create()
                ->setLine1(data_get($hit, 'locale_names.default.0'))
                ->setLine2(data_get($hit, 'suburb.0'))
                ->setCounty(data_get($hit, 'county.default.0'))
                ->setCity(data_get($hit, 'city.default.0'))
                ->setCountry(data_get($hit, 'country.default'))
                ->setPostalCode(data_get($hit, 'postcode.0'));
        });
    }

    protected function getHost()
    {
        return self::HOSTS[0] . "/{$this->apiVersion()}/places/query";
    }

    protected function apiVersion()
    {
        return "1";
    }

    protected function validateResultOrFail(Response $request)
    {
        if (!$request->successful()) {
            throw new AddressLookupFailed();
        }

        if (empty($request['hits'])) {
            throw new AddressLookupFailed();
        }

        return $request['hits'];
    }

    protected function getHeaders(): array
    {
        $id = config('postcode-lookup.drivers.algolia.app_id');
        $key = config('postcode-lookup.drivers.algolia.app_key');

        if (!$id || !$key) {
            return [];
        }

        return [
            'X-Algolia-Application-Id' => $id,
            'X-Algolia-API-Key' => $key
        ];
    }
}
