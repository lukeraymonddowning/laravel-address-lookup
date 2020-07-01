<?php

use Lukeraymonddowning\PostcodeLookup\Drivers\AlgoliaAddressLookup;

return [

    'default' => env("ADDRESS_LOOKUP_DRIVER", 'algolia'),

    'drivers' => [
        'algolia' => [
            'class' => AlgoliaAddressLookup::class,
            'app_id' => env("ALGOLIA_PLACES_APPLICATION_ID"),
            'app_key' => env("ALGOLIA_PLACES_APPLICATION_KEY")
        ]
    ]
];
