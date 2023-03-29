<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\ParcelController;
use EasyPost\EasyPostClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use VCRAccessories\CassetteSetup;

class ParcelControllerTest extends TestCase
{
    use RefreshDatabase;

    private static $client;
    private static $expireCassetteDays;

    /**
     * Setup the testing environment for this file.
     */
    public static function setUpBeforeClass(): void
    {
        CassetteSetup::setupVcrTests();
        self::$client = new EasyPostClient(getenv('EASYPOST_TEST_API_KEY'));
        self::$expireCassetteDays = 180;
    }

    /**
     * Cleanup the testing environment once finished.
     */
    public static function tearDownAfterClass(): void
    {
        CassetteSetup::teardownVcrTests();
    }

    /**
     * Tests that we show the parcels page correctly.
     *
     * @return void
     */
    public function testRetrieveParcels()
    {
        $controller = new ParcelController();

        $request = Request::create('/parcels', 'GET');
        $response = $controller->retrieveParcels($request);

        $viewData = $response->getData();

        $this->assertEmpty($viewData);
    }

    /**
     * Tests that we can create a Parcel correctly.
     *
     * @return void
     */
    public function testCreateParcels()
    {
        CassetteSetup::setupCassette('parcels/create.yml', self::$expireCassetteDays);
        $controller = new ParcelController();

        $request = Request::create('/parcels', 'POST', [
            'length' => 10.0,
            'width' => 10.0,
            'height' => 10.0,
            'weight' => 10.0,
        ]);
        $request->setLaravelSession(session());
        $request->session()->put(['client' => self::$client]);
        $response = $controller->createParcel($request);

        $this->assertNull($response->exception);
        $this->assertEquals(302, $response->getStatusCode());
    }
}
