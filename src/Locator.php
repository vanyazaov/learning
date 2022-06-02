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

        $url = 'https://api.ipgeolocation.io/ipgeo?' . http_build_query([
                'apiKey' => 'b72326c0a81b487f85804eb84f433b8a',
                'ip' => $ip
        ]);

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $data = array_map(fn($value) => $value !== '-' ? $value : null, $data);

        if (empty($data['country_name'])) {
            return null;
        }

        return new Location($data['country_name'], $data['state_prov'], $data['city']);
    }
}
