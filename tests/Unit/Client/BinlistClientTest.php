<?php

declare(strict_types=1);

namespace Test\Unit\Client;

use App\Client\BinlistClient;
use GuzzleHttp\Client;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class BinlistClientTest extends TestCase
{
    private const URI = 'test.test';

    private Client&MockObject $httpClient;
    private BinlistClient $binlistClient;

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(Client::class);
        $this->binlistClient = new BinlistClient($this->httpClient, self::URI);
    }

    public function testGetBinInfo(): void
    {
        $bin = '1234567';

        $responseData = [
            'country' => [
                'alpha2' => 'DKK',
            ]
        ];

        $responseBody = $this->createMock(StreamInterface::class);
        $responseBody->method('getContents')->willReturn(json_encode($responseData));

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($responseBody);

        $this->httpClient->expects(self::once())
            ->method('request')
            ->with('GET', sprintf('%s/%s', self::URI, $bin))
            ->willReturn($response);


        $binInfo = $this->binlistClient->getBinInfo($bin);

        $this->assertEquals('DKK', $binInfo->getCountry()->getAlpha2());
    }
}
