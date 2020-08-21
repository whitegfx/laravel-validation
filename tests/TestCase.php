<?php

namespace Whitegfx\LaravelValidation\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Foundation\Application;

/**
 * Override the standard PHPUnit testcase with the Testbench testcase
 *
 * @see https://github.com/orchestral/testbench#usage
 */
class TestCase extends OrchestraTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    /**
     * Include the package's service provider(s)
     *
     * @see https://github.com/orchestral/testbench#custom-service-provider
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Whitegfx\LaravelValidation\Providers\LaravelValidationServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
