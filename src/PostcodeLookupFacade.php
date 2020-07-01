<?php

namespace Lukeraymonddowning\PostcodeLookup;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lukeraymonddowning\PostcodeLookup\Skeleton\SkeletonClass
 */
class PostcodeLookupFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'postcode-lookup';
    }
}
