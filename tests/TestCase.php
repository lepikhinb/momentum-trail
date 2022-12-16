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

        Config::set('trail.output.routes', stream_get_meta_data(tmpfile())['uri']);
        Config::set('trail.output.typescript', stream_get_meta_data(tmpfile())['uri']);
    }

    protected function getPackageProviders($app)
    {
        return [
            TrailServiceProvider::class,
        ];
    }
}
