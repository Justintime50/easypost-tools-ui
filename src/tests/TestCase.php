<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected static $client;
    protected static $expireCassetteDays = 180;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }
}
