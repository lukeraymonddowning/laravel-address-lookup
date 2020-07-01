# Laravel Address Lookup

A small package to unify address lookups based on a search query. It currently has support for the Algolia Places API. 

## Installation

You can install the package via composer:

```bash
composer require lukeraymonddowning/laravel-address-lookup
```

## Usage

To lookup an address, you should obtain an instance of the `AddressLookup` interface out of the container, either through
the `app` helper function or by type hinting.

The default provider is Algolia, but you can change this by setting an `ADDRESS_LOOKUP_DRIVER` in your `.env` file with the desired driver key.

Here is an example of using the package to determine an address.

``` php
use Lukeraymonddowning\PostcodeLookup\Drivers\AddressLookup;

$addressLookup = app(AddressLookup::class);

$results = $addressLookup->lookup('1 Test Road, Some Street');
```

The `lookup` method will return a `Collection` of addresses, which conform to the `Lukeraymonddowning\PostcodeLookup\Address\AddressInterface`.

If there is an error retrieving results, an `AddressLookupFailed` exception will be thrown.

## Algolia

The Algolia places API can be used without any credentials, but usage is limited. You can add your own credentials to 
remove these limits. To do so, add the following keys to your `.env` file:

``` dotenv
ALGOLIA_PLACES_APPLICATION_ID=XXXX
ALGOLIA_PLACES_APPLICATION_KEY=XXXX
```

You should set the values of these keys to those obtained from the Algolia Places control panel.

### Important information

Whilst this package is open source, it is primarily used for internal business purposes and as such 
there should be no expectation of timely changes based on feature requests.

### Security

If you discover any security related issues, please email lukeraymonddowning@gmail.com instead of using the issue tracker.

## Credits

- [Luke Downing](https://github.com/lukeraymonddowning)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
