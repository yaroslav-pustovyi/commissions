<?php

declare(strict_types=1);

namespace App;

use App\Dependencies\ServiceProvider;
use Dotenv\Dotenv;

class AppBootstrap
{
    public function bootstrap(): App
    {
        $this->loadEnvVariables();

        $serviceProvider = new ServiceProvider();
        $factory = $serviceProvider->getTransactionFactory();
        $commissionHandler = $serviceProvider->getCommissionsHandler();

        return new App($commissionHandler, $factory);
    }

    private function loadEnvVariables(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }
}
