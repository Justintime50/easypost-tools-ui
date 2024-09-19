<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected static $client;
    protected static $expireCassetteDays = 180;
    protected static $prodApiKey;
    protected static $testApiKey;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        self::$prodApiKey = getenv('EASYPOST_PROD_API_KEY');
        self::$testApiKey = getenv('EASYPOST_TEST_API_KEY');
    }
}
