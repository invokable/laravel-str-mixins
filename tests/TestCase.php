<?php

declare(strict_types=1);

namespace Tests;

use Revolution\Laravel\Mixins\StrMixinsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            StrMixinsServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [];
    }

    protected function getEnvironmentSetUp($app): void
    {
        //
    }
}
