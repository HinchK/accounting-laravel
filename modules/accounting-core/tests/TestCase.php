<?php

declare(strict_types=1);

namespace Liberu\Accounting\Core\Tests;

use Illuminate\Events\Dispatcher;
use Illuminate\Events\EventServiceProvider;
use Liberu\PackageTestbench\PackageTestCase;

abstract class TestCase extends PackageTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance('events', new Dispatcher($this->app));
    }

    /**
     * The package dispatches domain events, so its isolated Testbench app must
     * include Laravel's event bindings explicitly.
     *
     * @param  mixed  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            EventServiceProvider::class,
            ...parent::getPackageProviders($app),
        ];
    }
}
