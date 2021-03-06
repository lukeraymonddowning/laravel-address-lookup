<?php

namespace Lukeraymonddowning\PostcodeLookup\Tests\Feature;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Lukeraymonddowning\PostcodeLookup\Address\AddressInterface;
use Lukeraymonddowning\PostcodeLookup\Drivers\AddressLookup;

class AddressLookupTest extends \Lukeraymonddowning\PostcodeLookup\Tests\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('postcode-lookup.default', null);
    }

    /** @test */
    public function it_can_be_retrieved_from_the_container()
    {
        $instance = app(AddressLookup::class);

        $this->assertInstanceOf(AddressLookup::class, $instance);
    }

    /** @test */
    public function it_returns_an_address_interface()
    {
        $result = app(AddressLookup::class)->lookup('foobar');

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(AddressInterface::class, $result->first());
    }
}
