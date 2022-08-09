<?php

namespace Tests\Functional;

use Fan\Laty\Laravel\FunctionalTestCase;
use Illuminate\Contracts\Console\Kernel;

abstract class TestCase extends FunctionalTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'https://local.api.firmchecker.com';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
