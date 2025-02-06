<?php

namespace Nnjeim\World\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Support\ServiceProvider;
use Nnjeim\World\WorldServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function defineEnvironment($app): void
    {
//        $app->useEnvironmentPath(__DIR__ . '/../../..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);
        $this->getEnvironmentSetUp($app);
    }

    /**
     * Get package providers.
     *
     * @param Application $app
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders($app)
    {
        return [
            WorldServiceProvider::class,
        ];
    }
}
