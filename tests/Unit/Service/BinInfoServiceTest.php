<?php

declare(strict_types=1);

namespace Test\Unit\Service;

use App\Client\BinInfoClientInterface;
use App\DTO\Bin\BinInfo;
use App\Service\BinInfoService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BinInfoServiceTest extends TestCase
{
    private BinInfoClientInterface&MockObject $binInfoClient;
    private BinInfoService $binInfoService;

    public function setUp(): void
    {
        $this->binInfoClient = $this->createMock(BinInfoClientInterface::class);
        $this->binInfoService = new BinInfoService($this->binInfoClient);
    }

    public function testGet(): void
    {
        $bin = '345311';
        $binInfo = BinInfo::fromArray(['country' => ['alpha2' => 'DKK']]);

        $this->binInfoClient->expects(self::once())
            ->method('getBinInfo')
            ->with($bin)
            ->willReturn($binInfo);

        $actualBinInfo = $this->binInfoService->get($bin);

        $this->assertSame($binInfo, $actualBinInfo);
    }
}
