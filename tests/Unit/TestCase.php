<?php

namespace KFoobar\Uuid\Test\Unit;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    protected function defineEnvironment($app)
    {
        $app['config']->set('database.default', 'testing');
    }
}
