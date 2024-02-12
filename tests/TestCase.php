<?php

namespace Teners\LaravelExtras\Tests;

use Orchestra\Testbench\TestCase as TestbenchTestCase;

abstract class TestCase extends TestbenchTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('laravel-extras', require __DIR__.'/../config/laravel-extras.php');
    }
}
