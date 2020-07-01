<?php

namespace Lukeraymonddowning\PostcodeLookup\Tests\Feature;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Lukeraymonddowning\PostcodeLookup\Address\AddressInterface;
use Lukeraymonddowning\PostcodeLookup\Drivers\AddressLookup;
use Lukeraymonddowning\PostcodeLookup\Drivers\AlgoliaAddressLookup;
use Lukeraymonddowning\PostcodeLookup\Tests\TestCase;

class AlgoliaAddressLookupTest extends TestCase
{
    /** @test */
    public function it_can_be_retrieved_from_the_container()
    {
        $instance = app(AddressLookup::class);

        $this->assertInstanceOf(AlgoliaAddressLookup::class, $instance);
    }

    /** @test */
    public function it_can_search_using_a_query()
    {
        $this->mockOutLookup();
        $results = app(AddressLookup::class)->lookup('15 Alma Street, North Wingfield');

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertInstanceOf(AddressInterface::class, $results->first());
    }

    protected function mockOutLookup()
    {
        $returnValue = '{"hits":[{"country":{"de":"Vereinigtes K\u00f6nigreich","ru":"\u0412\u0435\u043b\u0438\u043a\u043e\u0431\u0440\u0438\u0442\u0430\u043d\u0438\u044f","pt":"Reino Unido","it":"Regno Unito","fr":"Royaume-Uni","hu":"Egyes\u00fclt Kir\u00e1lys\u00e1g","zh":"\u82f1\u56fd","es":"Reino Unido","ar":"\u0627\u0644\u0645\u0645\u0644\u0643\u0629 \u0627\u0644\u0645\u062a\u062d\u062f\u0629","default":"United Kingdom","ja":"\u30a4\u30ae\u30ea\u30b9","pl":"Wielka Brytania","ro":"Marea Britanie","nl":"Verenigd Koninkrijk"},"is_country":false,"city":{"default":["North East Derbyshire"]},"is_highway":true,"importance":26,"_tags":["highway","highway\/residential","country\/gb","address","source\/osm"],"postcode":["S42 5NB"],"county":{"default":["Derbyshire"]},"population":0,"country_code":"gb","is_city":false,"is_popular":false,"administrative":["England","East Midlands"],"admin_level":15,"suburb":["North Wingfield"],"is_suburb":false,"locale_names":{"default":["Alma Street"]},"_geoloc":{"lat":53.1805,"lng":-1.39857},"objectID":"98745681_58462694","_highlightResult":{"country":{"de":{"value":"Vereinigtes K\u00f6nigreich","matchLevel":"none","matchedWords":[]},"ru":{"value":"\u0412\u0435\u043b\u0438\u043a\u043e\u0431\u0440\u0438\u0442\u0430\u043d\u0438\u044f","matchLevel":"none","matchedWords":[]},"pt":{"value":"Reino Unido","matchLevel":"none","matchedWords":[]},"it":{"value":"Regno Unito","matchLevel":"none","matchedWords":[]},"fr":{"value":"Royaume-Uni","matchLevel":"none","matchedWords":[]},"hu":{"value":"Egyes\u00fclt Kir\u00e1lys\u00e1g","matchLevel":"none","matchedWords":[]},"zh":{"value":"\u82f1\u56fd","matchLevel":"none","matchedWords":[]},"es":{"value":"Reino Unido","matchLevel":"none","matchedWords":[]},"ar":{"value":"\u0627\u0644\u0645\u0645\u0644\u0643\u0629 \u0627\u0644\u0645\u062a\u062d\u062f\u0629","matchLevel":"none","matchedWords":[]},"default":{"value":"United Kingdom","matchLevel":"none","matchedWords":[]},"ja":{"value":"\u30a4\u30ae\u30ea\u30b9","matchLevel":"none","matchedWords":[]},"pl":{"value":"Wielka Brytania","matchLevel":"none","matchedWords":[]},"ro":{"value":"Marea Britanie","matchLevel":"none","matchedWords":[]},"nl":{"value":"Verenigd Koninkrijk","matchLevel":"none","matchedWords":[]}},"city":{"default":[{"value":"<em>North<\/em> East Derbyshire","matchLevel":"partial","fullyHighlighted":false,"matchedWords":["north"]}]},"postcode":[{"value":"S42 5NB","matchLevel":"none","matchedWords":[]}],"county":{"default":[{"value":"Derbyshire","matchLevel":"none","matchedWords":[]}]},"administrative":[{"value":"England","matchLevel":"none","matchedWords":[]},{"value":"East Midlands","matchLevel":"none","matchedWords":[]}],"suburb":[{"value":"<em>North<\/em> <em>Wingfield<\/em>","matchLevel":"partial","fullyHighlighted":true,"matchedWords":["north","wingfield"]}],"locale_names":{"default":[{"value":"<em>Alma<\/em> <em>Street<\/em>","matchLevel":"partial","fullyHighlighted":false,"matchedWords":["alma","street"]}]}}}],"nbHits":1,"processingTimeMS":34,"query":"Alma Street, North Wingfield","params":"query=Alma+Street%2C+North+Wingfield","degradedQuery":false}';

        Http::fake(
            [
                'https://places*' => Http::response(json_decode($returnValue, true), 200)
            ]
        );
    }

    /** @test */
    public function if_an_app_id_and_key_is_set_it_is_included_in_the_request()
    {
        Config::set('postcode-lookup.drivers.algolia.app_id', '1234');
        Config::set('postcode-lookup.drivers.algolia.app_key', '4321');

        $this->mockOutLookup();
        app(AddressLookup::class)->lookup('15 Alma Street, North Wingfield');

        Http::assertSent(
            function ($request) {
                return $request->hasHeader('X-Algolia-Application-Id', '1234') &&
                    $request->hasHeader('X-Algolia-API-Key', '4321');
            }
        );
    }

    /** @test */
    public function if_an_app_id_and_key_are_not_present_it_doesnt_send_the_headers()
    {
        $this->mockOutLookup();

        Http::assertNotSent(
            function (Request $request) {
                return $request->header('X-Algolia-Application-Id') ||
                    $request->hasHeader('X-Algolia-API-Key');
            }
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        Config::set('postcode-lookup.default', 'algolia');
    }
}
