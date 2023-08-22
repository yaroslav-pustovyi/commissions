<?php

declare(strict_types=1);

namespace Test\Unit\Service;

use App\DTO\Bin\BinInfo;
use App\DTO\TransactionInputData;
use App\Service\BinInfoService;
use App\Service\CommissionsHandler;
use App\Service\EUCountryChecker;
use App\Service\RateService;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CommissionsHandlerTest extends TestCase
{
    private BinInfoService&MockObject $binInfoService;
    private RateService&MockObject $rateService;
    private EUCountryChecker&MockObject $euCountryChecker;
    private CommissionsHandler $handler;

    public function setUp(): void
    {
        $this->binInfoService = $this->createMock(BinInfoService::class);
        $this->rateService = $this->createMock(RateService::class);
        $this->euCountryChecker = $this->createMock(EUCountryChecker::class);
        $this->handler = new CommissionsHandler(
            $this->binInfoService,
            $this->rateService,
            $this->euCountryChecker
        );
    }

    public function testHandleWithRate(): void
    {
        $bin = '1234567';
        $transaction = new TransactionInputData($bin, new Money('20000.0', new Currency('EUR')));
        $binInfo = BinInfo::fromArray([
            'country' => [
                'alpha2' => 'LT',
            ]
        ]);

        $this->binInfoService->expects(self::once())
            ->method('get')
            ->with($bin)
            ->willReturn($binInfo);

        $rate = 3.0;
        $this->rateService->expects(self::once())
            ->method('getRateForCurrency')
            ->with('EUR')
            ->willReturn($rate);

        $this->euCountryChecker->expects(self::once())
            ->method('isEu')
            ->with('LT')
            ->willReturn(true);

        $expectedResult = $transaction->paidAmount->divide((string)$rate)->multiply('0.01');

        $actualResult = $this->handler->handle($transaction);

        $this->assertTrue($expectedResult->equals($actualResult));
    }

    public function testHandleNotFromEU(): void
    {
        $bin = '1234567';
        $transaction = new TransactionInputData($bin, new Money('20000.0', new Currency('USD')));
        $binInfo = BinInfo::fromArray([
            'country' => [
                'alpha2' => 'US',
            ]
        ]);

        $this->binInfoService->expects(self::once())
            ->method('get')
            ->with($bin)
            ->willReturn($binInfo);

        $rate = 0.0;
        $this->rateService->expects(self::once())
            ->method('getRateForCurrency')
            ->with('USD')
            ->willReturn($rate);

        $this->euCountryChecker->expects(self::once())
            ->method('isEu')
            ->with('US')
            ->willReturn(false);

        $expectedResult = $transaction->paidAmount->multiply('0.02');

        $actualResult = $this->handler->handle($transaction);

        $this->assertTrue($expectedResult->equals($actualResult));
    }
}
