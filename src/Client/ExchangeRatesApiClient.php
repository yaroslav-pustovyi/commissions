<?php

declare(strict_types=1);

namespace App\Client;

use GuzzleHttp\Client;

class ExchangeRatesApiClient implements RateClientInterface
{
    public function __construct(
        private readonly Client $httpClient,
        private readonly string $uri,
        private readonly string $accessKey
    ) {
    }

    public function getRates(): array
    {
        $response = $this->httpClient->request('GET', sprintf('%s?access_key=%s', $this->uri, $this->accessKey));

        return json_decode($response->getBody()->getContents(), true)['rates'];
    }
}
