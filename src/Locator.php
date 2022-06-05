<?php

declare(strict_types=1);

namespace Vankazaov\Ip2geoLocator;


class Locator
{
    private $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function locate(Ip $ip): ?Location
    {
        $url = 'https://api.ipgeolocation.io/ipgeo?' . http_build_query([
                'apiKey' => 'b72326c0a81b487f85804eb84f433b8a',
                'ip' => $ip->getValue()
        ]);

        $response = $this->client->get($url);
        $data = json_decode($response, true);

        if (empty($data)) return null;

        $data = array_map(fn($value) => $value !== '-' ? $value : null, $data);

        if (empty($data['country_name'])) {
            return null;
        }

        return new Location($data['country_name'], $data['state_prov'], $data['city']);
    }
}
