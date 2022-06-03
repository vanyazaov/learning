<?php

declare(strict_types=1);

namespace Test\Vankazaov\Ip2geoLocator;

use PHPUnit\Framework\TestCase;
use Vankazaov\Ip2geoLocator\Ip;

class IpTest extends TestCase
{
    public function testIp4(): void
    {
        $ip = new Ip($value = '8.8.8.8');
        self::assertEquals($value, $ip->getValue());
    }

    public function testIp6(): void
    {
        $ip = new Ip($value = '2001:4860:4860::8888');
        self::assertEquals($value, $ip->getValue());
    }

    public function testInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Ip('incorrect');
    }

    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Ip('');
    }
}
