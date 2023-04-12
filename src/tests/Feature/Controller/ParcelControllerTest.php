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
    public function testCreateParcel()
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

    /**
     * Tests that we can create a Predefined Package Parcel correctly.
     *
     * @return void
     */
    public function testCreateParcelPredefinedPackage()
    {
        CassetteSetup::setupCassette('parcels/createPredefinedPackage.yml', self::$expireCassetteDays);
        $controller = new ParcelController();

        $request = Request::create('/parcels', 'POST', [
            'predefined_package' => 'Parcel',
            'weight' => 10.0,
        ]);
        $request->setLaravelSession(session());
        $request->session()->put(['client' => self::$client]);
        $response = $controller->createParcel($request);

        $this->assertNull($response->exception);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we return an error correctly when creating a Parcel.
     *
     * @return void
     */
    public function testCreateParcelException()
    {
        CassetteSetup::setupCassette('parcels/createException.yml', self::$expireCassetteDays);
        $controller = new ParcelController();

        $request = Request::create('/parcels', 'POST', ['weight' => 0]);
        $request->setLaravelSession(session());
        $request->session()->put(['client' => self::$client]);
        $response = $controller->createParcel($request);

        $this->assertEquals('Wrong parameter type.', $response->getSession()->get('error'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can create a Parcel correctly.
     *
     * @return void
     */
    public function testRetrieveParcel()
    {
        CassetteSetup::setupCassette('parcels/retrieve.yml', self::$expireCassetteDays);
        $controller = new ParcelController();

        // TODO: Make this dynamic, is that possible with our setup?
        $parcelId = 'prcl_a2c01c778a39467da5b148c6d344d90c';

        $request = Request::create("/parcels/$parcelId", 'GET');
        $request->setLaravelSession(session());
        $request->session()->put(['client' => self::$client]);
        $response = $controller->retrieveParcel($request, $parcelId);

        $viewData = $response->getData();

        $this->assertNull($response->exception);
        $this->assertEquals($parcelId, $viewData['json']['id']);
    }

    /**
     * Tests that we return an error correctly when retrieving a Parcel.
     *
     * @return void
     */
    public function testRetrieveParcelException()
    {
        CassetteSetup::setupCassette('parcels/retrieveException.yml', self::$expireCassetteDays);
        $controller = new ParcelController();

        $parcelId = 'bad_id';

        $request = Request::create("/parcels/$parcelId", 'GET');
        $request->setLaravelSession(session());
        $request->session()->put(['client' => self::$client]);
        $response = $controller->retrieveParcel($request, $parcelId);

        $this->assertEquals('The requested resource could not be found.', $response->getSession()->get('error'));
        $this->assertEquals(302, $response->getStatusCode());
    }
}
