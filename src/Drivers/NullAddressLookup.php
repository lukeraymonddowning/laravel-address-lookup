<?php


namespace Lukeraymonddowning\PostcodeLookup\Drivers;


use Faker\Factory;
use Illuminate\Support\Collection;
use Lukeraymonddowning\PostcodeLookup\Address\SimpleAddress;

class NullAddressLookup implements AddressLookup
{

    public function lookup(string $query): Collection
    {
        $faker = Factory::create('en_GB');

        $numberOfAddresses = $faker->numberBetween(3, 12);
        $addresses = [];

        for($i = 0; $i < $numberOfAddresses; $i++) {
            $addresses[] = SimpleAddress::create()
                ->setLine1($faker->streetAddress)
                ->setLine2($faker->secondaryAddress)
                ->setCity($faker->city)
                ->setCounty($faker->county)
                ->setPostalCode($faker->postcode)
                ->setCountry($faker->country);
        }

        return collect($addresses);
    }
}
