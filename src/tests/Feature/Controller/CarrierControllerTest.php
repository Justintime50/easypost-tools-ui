<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\CarrierController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use VCRAccessories\CassetteSetup;

class CarrierControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the testing environment for this file.
     */
    public static function setUpBeforeClass(): void
    {
        CassetteSetup::setupVcrTests();
        self::$controller = new CarrierController();
    }

    /**
     * Cleanup the testing environment once finished.
     */
    public static function tearDownAfterClass(): void
    {
        CassetteSetup::teardownVcrTests();
    }

    /**
     * Tests that we can create a Carrier correctly.
     *
     * @return void
     */
    public function testRetrieveCarrier()
    {
        CassetteSetup::setupCassette('carriers/retrieve.yml', self::$expireCassetteDays);

        // TODO: Make this dynamic, is that possible with our setup?
        $id = 'ca_4fcd9a658b494a979793bb899a40c5b5';

        $request = Request::create("/carriers/$id", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$prodApiKey]);
        $response = self::$controller->retrieveCarrier($request, $id);

        $viewData = $response->getData();

        $this->assertNull($response->exception);
        $this->assertEquals($id, $viewData['json']['id']);
    }

    /**
     * Tests that we return an error correctly when retrieving a Carrier.
     *
     * @return void
     */
    public function testRetrieveCarrierException()
    {
        CassetteSetup::setupCassette('carriers/retrieveException.yml', self::$expireCassetteDays);

        $id = 'bad_id';

        $request = Request::create("/carriers/$id", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$prodApiKey]);
        $response = self::$controller->retrieveCarrier($request, $id);

        $this->assertEquals('The requested resource could not be found.', $response->getSession()->get('error'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we show the carriers page correctly.
     *
     * @return void
     */
    public function testRetrieveCarriers()
    {
        CassetteSetup::setupCassette('carriers/retrieveCarriers.yml', self::$expireCassetteDays);

        $request = Request::create('/carriers', 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$prodApiKey]);
        $response = self::$controller->retrieveCarriers($request);

        $viewData = $response->getData();

        $this->assertNotNull($viewData['json']);
    }
}
