<?php

namespace Lukeraymonddowning\PostcodeLookup\Tests;

use Orchestra\Testbench\TestCase;
use Lukeraymonddowning\PostcodeLookup\PostcodeLookupServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [PostcodeLookupServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
