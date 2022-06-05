<?php

declare(strict_types=1);

namespace Test\Vankazaov\Ip2geoLocator;

use PHPUnit\Framework\TestCase;
use Vankazaov\Ip2geoLocator\Ip;
use Vankazaov\Ip2geoLocator\Locator;

class LocatorTest extends TestCase
{
    public function testSuccess(): void
    {
        $locator = new Locator();
        $location = $locator->locate(new Ip('8.8.8.8'));

        self::assertNotNull($location);
        self::assertEquals('United States', $location->getCountry());
        self::assertEquals('Louisiana', $location->getRegion());
        self::assertEquals('Monroe', $location->getCity());
    }

    public function testNotFound(): void
    {
        $locator = new Locator();
        $this->expectException(\RuntimeException::class);
        $location = $locator->locate(new Ip('127.0.0.1'));
        self::assertNull($location);
    }
}
