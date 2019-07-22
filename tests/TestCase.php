<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication {
        createApplication as createTestedApplication;
    }

    public function createApplication()
    {
        $app = $this->createTestedApplication();
        $this->registerConnection();

        return $app;
    }

    private function registerConnection()
    {
        $config = app('config');
        $connectionName = $config->get('database.default');
        $connectionKey = sprintf('database.connections.%s', $connectionName);
        $DbTestPrefix = env('DB_TEST_PREFIX', 'test_');
        $connection = $config->get($connectionKey);
        $connection['database'] = $DbTestPrefix.$connection['database'];

        $config->set($connectionKey, $connection);
        DB::setDefaultConnection($connectionName);
    }
}
