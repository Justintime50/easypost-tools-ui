<?php

namespace Tests;

use VCR\VCR;

class Util
{
    /**
     * Runs all the logic required to setup a VCR test.
     *
     * @return void
     */
    public static function setupVcrTests()
    {
        VCR::turnOn();
    }

    /**
     * Runs all the logic required to teardown a VCR test.
     *
     * @return void
     */
    public static function teardownVcrTests()
    {
        VCR::eject();
        VCR::turnOff();
    }

    /**
     * Inserts a cassette for use in tests.
     *
     * @param string $cassettePath
     * @return void
     */
    public static function setupCassette($cassettePath)
    {
        VCR::insertCassette($cassettePath);
    }
}
