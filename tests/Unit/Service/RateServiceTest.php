<?php

declare(strict_types=1);

namespace Test\Unit\Service;

use App\Client\RateClientInterface;
use App\Exception\RateNotFoundException;
use App\Service\RateService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RateServiceTest extends TestCase
{
    private RateClientInterface&MockObject $rateClient;
    private RateService $rateService;

    public function setUp(): void
    {
        $this->rateClient = $this->createMock(RateClientInterface::class);
        $this->rateService = new RateService($this->rateClient);
    }

    public function testGetRateForCurrency(): void
    {
        $rates = [
            'USD' => 1.2,
            'EUR' => 14.6,
            'GBP' => 5.9,
        ];

        $this->rateClient->expects(self::once())
            ->method('getRates')
            ->willReturn($rates);

        $rate = $this->rateService->getRateForCurrency('GBP');

        $this->assertEquals(5.9, $rate);
    }

    public function testGetRateForCurrencyWhenRateIsNotFound(): void
    {
        $rates = [
            'USD' => 1.2,
            'EUR' => 14.6,
            'GBP' => 5.9,
        ];

        $this->rateClient->expects(self::once())
            ->method('getRates')
            ->willReturn($rates);

        $this->expectException(RateNotFoundException::class);

        $this->rateService->getRateForCurrency('DKK');
    }
}
