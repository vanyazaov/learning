<?php

declare(strict_types=1);

namespace Vankazaov\Ip2geoLocator;

use http\Exception\InvalidArgumentException;

class Locator
{
    public function locate(string $ip): ?Location
    {
        if (empty($ip)) {
            throw new InvalidArgumentException('Empty IP.');
        }

        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            throw new InvalidArgumentException('Invalid IP ' . $ip);
        }
    }
}
