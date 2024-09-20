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
     * Tests that we retrieve a refund correctly.
     *
     * @return void
     */
    public function testRetrieveRefund()
    {
        CassetteSetup::setupCassette('refunds/retrieveRefund.yml', self::$expireCassetteDays);

        // TODO: Make this dynamic, is that possible with our setup?
        $id = 'rfnd_d1b8d893ee2a4de3ba37573d5902020b';

        $request = Request::create("/refunds/$id", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveRefund($request, $id);

        $viewData = $response->getData();

        $this->assertNull($response->exception);
        $this->assertEquals($id, $viewData['json']['id']);
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
