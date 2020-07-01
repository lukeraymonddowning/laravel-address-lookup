<?php


namespace Lukeraymonddowning\PostcodeLookup\Tests;


use Lukeraymonddowning\PostcodeLookup\AddressLookupServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function getPackageProviders($app)
    {
        return [
            AddressLookupServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
    }

    protected function setUp(): void
    {
        parent::setUp();
    }

}
