<?php

declare(strict_types=1);

namespace App\Dependencies;

use App\Client\BinInfoClientInterface;
use App\Client\BinlistClient;
use App\Client\ExchangeRatesApiClient;
use App\Client\RateClientInterface;
use App\Factory\TransactionInputDataFactoryInterface;
use App\Factory\TransactionInputDataFactory;
use App\Service\BinInfoService;
use App\Service\CommissionsHandler;
use App\Service\CommissionsHandlerInterface;
use App\Service\EUCountryChecker;
use App\Service\RateService;
use GuzzleHttp\Client;

class ServiceProvider
{
    public function getTransactionFactory(): TransactionInputDataFactoryInterface
    {
        return new TransactionInputDataFactory();
    }

    public function getCommissionsHandler(): CommissionsHandlerInterface
    {
        return new CommissionsHandler($this->getBinInfoService(), $this->getRateService(), $this->getEuChecker());
    }

    public function getBinInfoClient(): BinInfoClientInterface
    {
        return new BinlistClient(new Client(), $_ENV['BIN_CLIENT_URI']);
    }

    public function getBinInfoService(): BinInfoService
    {
        return new BinInfoService($this->getBinInfoClient());
    }

    public function getRateClient(): RateClientInterface
    {
        return new ExchangeRatesApiClient(new Client(), $_ENV['RATE_CLIENT_URI'], $_ENV['RATE_CLIENT_API_ACCESS_KEY']);
    }

    public function getRateService(): RateService
    {
        return new RateService($this->getRateClient());
    }

    public function getEuChecker(): EUCountryChecker
    {
        return new EUCountryChecker();
    }
}
