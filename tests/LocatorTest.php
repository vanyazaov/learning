<?php

declare(strict_types=1);

namespace Test\Vankazaov\Ip2geoLocator;

use PHPUnit\Framework\TestCase;
use Vankazaov\Ip2geoLocator\HttpClient;
use Vankazaov\Ip2geoLocator\Ip;
use Vankazaov\Ip2geoLocator\Locator;

class LocatorTest extends TestCase
{
    public function testSuccess(): void
    {
        $client = $this->createMock(HttpClient::class);

        $client->method('get')->willReturn(json_encode([
            'country_name' => 'United States',
            'state_prov' => 'Louisiana',
            'city' => 'Monroe'
        ]));

        $locator = new Locator($client, 'b72326c0a81b487f85804eb84f433b8a');
        $location = $locator->locate(new Ip('8.8.8.8'));

        self::assertNotNull($location);
        self::assertEquals('United States', $location->getCountry());
        self::assertEquals('Louisiana', $location->getRegion());
        self::assertEquals('Monroe', $location->getCity());
    }

    public function testNotFound(): void
    {
        $client = $this->createMock(HttpClient::class);
        $client->method('get')->willReturn(json_encode([
            'country_name' => '-',
            'state_prov' => '-',
            'city' => '-'
        ]));

        $locator = new Locator($client, 'b72326c0a81b487f85804eb84f433b8a');
        $location = $locator->locate(new Ip('127.0.0.1'));
        self::assertNull($location);
    }
}
