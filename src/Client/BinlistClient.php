<?php

declare(strict_types=1);

namespace App\Client;

use App\DTO\Bin\BinInfo;
use GuzzleHttp\Client;

class BinlistClient implements BinInfoClientInterface
{
    public function __construct(private readonly Client $httpClient, private readonly string $uri)
    {
    }

    public function getBinInfo(string $bin): BinInfo
    {
        $response = $this->httpClient->request('GET', sprintf('%s/%s', $this->uri, $bin));
        $responseData = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        return BinInfo::fromArray($responseData);
    }
}
