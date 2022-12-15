<?php

declare(strict_types=1);

namespace Momentum\Trail\Tests;

use Illuminate\Support\Facades\Config;
use Momentum\Trail\TrailServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('trail.path', sys_get_temp_dir() . '/trail');
    }

    protected function getPackageProviders($app)
    {
        return [
            TrailServiceProvider::class,
        ];
    }
}
