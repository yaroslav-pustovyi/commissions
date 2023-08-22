<?php

declare(strict_types=1);

namespace Test\Unit;

use App\App;
use App\DTO\TransactionInputData;
use App\Factory\TransactionInputDataFactoryInterface;
use App\Service\CommissionsHandlerInterface;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    private CommissionsHandlerInterface&MockObject $commissionsHandler;
    private TransactionInputDataFactoryInterface&MockObject $transactionInputDataFactory;
    private App $app;

    public function setUp(): void
    {
        $this->commissionsHandler = $this->createMock(CommissionsHandlerInterface::class);
        $this->transactionInputDataFactory = $this->createMock(TransactionInputDataFactoryInterface::class);
        $this->app = new App(
            $this->commissionsHandler,
            $this->transactionInputDataFactory
        );
    }

    public function testRun(): void
    {
        $data = ['bin' => '123456', 'amount' => '1000.0', 'currency' => 'EUR'];

        $transaction = new TransactionInputData('123456', new Money('1000.0', new Currency('EUR')));

        $this->transactionInputDataFactory->expects(self::once())
            ->method('createFromArray')
            ->with($data)
            ->willReturn($transaction);

        $this->commissionsHandler->expects(self::once())
            ->method('handle')
            ->with($transaction)
            ->willReturn(new Money('1500.0', new Currency('EUR')));

        $result = $this->app->run($data);

        $this->assertEquals(15, $result);
    }
}
