<?php

declare(strict_types=1);

namespace Test\Client;

use App\Client\ExchangeRatesApiClient;
use GuzzleHttp\Client;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ExchangeRatesApiClientTest extends TestCase
{
    private const URI = 'test.test';
    private const ACCESS_KEY = 'test_access_key';

    private Client&MockObject $httpClient;
    private ExchangeRatesApiClient $ratesApiClient;

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(Client::class);
        $this->ratesApiClient = new ExchangeRatesApiClient(
            $this->httpClient,
            self::URI,
            self::ACCESS_KEY
        );
    }

    public function testGetRates(): void
    {
        $responseData = [
            'rates' => ['USD' => 5]
        ];

        $responseBody = $this->createMock(StreamInterface::class);
        $responseBody->method('getContents')->willReturn(json_encode($responseData));

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($responseBody);

        $this->httpClient->expects(self::once())
            ->method('request')
            ->with('GET', sprintf('%s?access_key=%s', self::URI, self::ACCESS_KEY))
            ->willReturn($response);

        $rates = $this->ratesApiClient->getRates();

        $this->assertSame($responseData['rates'], $rates);
    }
}
