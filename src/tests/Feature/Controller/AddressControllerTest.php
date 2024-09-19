<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\AddressController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use VCRAccessories\CassetteSetup;

class AddressControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the testing environment for this file.
     */
    public static function setUpBeforeClass(): void
    {
        CassetteSetup::setupVcrTests();
        self::$controller = new AddressController();
    }

    /**
     * Cleanup the testing environment once finished.
     */
    public static function tearDownAfterClass(): void
    {
        CassetteSetup::teardownVcrTests();
    }

    /**
     * Tests that we can create an Address correctly.
     *
     * @return void
     */
    public function testCreateAddress()
    {
        CassetteSetup::setupCassette('addresses/create.yml', self::$expireCassetteDays);

        $request = Request::create('/addresses', 'POST', [
            'name' => 'Jack Sparrow',
            'street1' => '388 Townsend St',
            'street2' => 'Apt 20',
            'city' => 'San Francisco',
            'state' => 'CA',
            'zip' => '94107',
            'country' => 'US',
            'email' => 'test@example.com',
            'phone' => '555555555'
        ]);
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->createAddress($request);

        $this->assertNull($response->exception);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can create a Address correctly.
     *
     * @return void
     */
    public function testRetrieveAddress()
    {
        CassetteSetup::setupCassette('addresses/retrieve.yml', self::$expireCassetteDays);

        // TODO: Make this dynamic, is that possible with our setup?
        $id = 'adr_04cd8db376af11efb060ac1f6bc53342';

        $request = Request::create("/addresses/$id", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveAddress($request, $id);

        $viewData = $response->getData();

        $this->assertNull($response->exception);
        $this->assertEquals($id, $viewData['json']['id']);
    }

    /**
     * Tests that we return an error correctly when retrieving a Address.
     *
     * @return void
     */
    public function testRetrieveAddressException()
    {
        CassetteSetup::setupCassette('addresses/retrieveException.yml', self::$expireCassetteDays);

        $id = 'bad_id';

        $request = Request::create("/addresses/$id", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveAddress($request, $id);

        $this->assertEquals('The requested resource could not be found.', $response->getSession()->get('error'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we show the addresses page correctly.
     *
     * @return void
     */
    public function testRetrieveAddresses()
    {
        CassetteSetup::setupCassette('addresses/retrieveAddresses.yml', self::$expireCassetteDays);

        $request = Request::create('/addresses', 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveAddresses($request);

        $viewData = $response->getData();

        $this->assertNotNull($viewData['json']);
    }
}
