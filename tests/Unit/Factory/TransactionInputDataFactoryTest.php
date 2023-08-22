<?php

declare(strict_types=1);

namespace Test\Unit\Factory;

use App\Factory\TransactionInputDataFactory;
use PHPUnit\Framework\TestCase;

class TransactionInputDataFactoryTest extends TestCase
{
    private TransactionInputDataFactory $factory;

    public function setUp(): void
    {
        $this->factory = new TransactionInputDataFactory();
    }

    /** @dataProvider transactionInputDataProvider */
    public function testCreateFromArray(array $data): void
    {
        $transaction = $this->factory->createFromArray($data);

        $this->assertEquals($data['bin'], $transaction->bin);
        $this->assertEquals($data['amount'] * 100, $transaction->paidAmount->getAmount());
        $this->assertEquals($data['currency'], $transaction->paidAmount->getCurrency()->getCode());
    }

    public static function transactionInputDataProvider(): array
    {
        return [
            [
                [
                    'bin' => '1111222333',
                    'amount' => '100.00',
                    'currency' => 'USD',
                ],
            ],
            [
                [
                    'bin' => '4444555666',
                    'amount' => '500.00',
                    'currency' => 'EUR',
                ],
            ],
            [
                [
                    'bin' => '777888999',
                    'amount' => '1000.00',
                    'currency' => 'GPB',
                ],
            ],
        ];
    }
}
