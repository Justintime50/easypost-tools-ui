<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\ParcelController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use VCRAccessories\CassetteSetup;

class ParcelControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the testing environment for this file.
     */
    public static function setUpBeforeClass(): void
    {
        CassetteSetup::setupVcrTests();
        self::$controller = new ParcelController();
    }

    /**
     * Cleanup the testing environment once finished.
     */
    public static function tearDownAfterClass(): void
    {
        CassetteSetup::teardownVcrTests();
    }

    /**
     * Tests that we can create a Parcel correctly.
     *
     * @return void
     */
    public function testCreateParcel()
    {
        CassetteSetup::setupCassette('parcels/create.yml', self::$expireCassetteDays);

        $request = Request::create('/parcels', 'POST', [
            'length' => 10.0,
            'width' => 10.0,
            'height' => 10.0,
            'weight' => 10.0,
        ]);
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->createParcel($request);

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

        $request = Request::create('/parcels', 'POST', [
            'predefined_package' => 'Parcel',
            'weight' => 10.0,
        ]);
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->createParcel($request);

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

        $request = Request::create('/parcels', 'POST', ['weight' => 0]);
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->createParcel($request);

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

        // TODO: Make this dynamic, is that possible with our setup?
        $id = 'prcl_a2c01c778a39467da5b148c6d344d90c';

        $request = Request::create("/parcels/$id", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveParcel($request, $id);

        $viewData = $response->getData();

        $this->assertNull($response->exception);
        $this->assertEquals($id, $viewData['json']['id']);
    }

    /**
     * Tests that we return an error correctly when retrieving a Parcel.
     *
     * @return void
     */
    public function testRetrieveParcelException()
    {
        CassetteSetup::setupCassette('parcels/retrieveException.yml', self::$expireCassetteDays);

        $id = 'bad_id';

        $request = Request::create("/parcels/$id", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveParcel($request, $id);

        $this->assertEquals('The requested resource could not be found.', $response->getSession()->get('error'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we show the parcels page correctly.
     *
     * @return void
     */
    public function testRetrieveParcels()
    {
        $request = Request::create('/parcels', 'GET');
        $response = self::$controller->retrieveParcels($request);

        $viewData = $response->getData();

        $this->assertEmpty($viewData);
    }
}
