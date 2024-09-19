<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\RefundController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use VCRAccessories\CassetteSetup;

class RefundControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the testing environment for this file.
     */
    public static function setUpBeforeClass(): void
    {
        CassetteSetup::setupVcrTests();
        self::$controller = new RefundController();
    }

    /**
     * Cleanup the testing environment once finished.
     */
    public static function tearDownAfterClass(): void
    {
        CassetteSetup::teardownVcrTests();
    }

    /**
     * Tests that we show the refunds page correctly.
     *
     * @return void
     */
    public function testRetrieveRefunds()
    {
        CassetteSetup::setupCassette('refunds/retrieveRefunds.yml', self::$expireCassetteDays);

        $request = Request::create('/refunds', 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveRefunds($request);

        $viewData = $response->getData();

        $this->assertNotNull($viewData['json']);
    }
}
