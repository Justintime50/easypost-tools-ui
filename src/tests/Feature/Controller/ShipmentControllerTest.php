<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\ShipmentController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use VCRAccessories\CassetteSetup;

class ShipmentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the testing environment for this file.
     */
    public static function setUpBeforeClass(): void
    {
        CassetteSetup::setupVcrTests();
        self::$controller = new ShipmentController();
    }

    /**
     * Cleanup the testing environment once finished.
     */
    public static function tearDownAfterClass(): void
    {
        CassetteSetup::teardownVcrTests();
    }

    /**
     * Tests that we can create an Shipment correctly.
     *
     * @return void
     */
    public function testCreateShipment()
    {
        CassetteSetup::setupCassette('shipments/create.yml', self::$expireCassetteDays);

        $request = Request::create('/shipments', 'POST', [
            'from_name' => 'Jack Sparrow',
            'from_street1' => '388 Townsend St',
            'from_street2' => 'Apt 20',
            'from_city' => 'San Francisco',
            'from_state' => 'CA',
            'from_zip' => '94107',
            'from_country' => 'US',
            'from_email' => 'test@example.com',
            'from_phone' => '5555555555',
            'to_name' => 'Elizabeth Swan',
            'to_street1' => '179 N Harbor Dr',
            'to_city' => 'Redondo Beach',
            'to_state' => 'CA',
            'to_zip' => '90277',
            'to_country' => 'US',
            'to_email' => 'test@example.com',
            'to_phone' => '5555555555',
            'length' => '10',
            'width' => '8',
            'height' => '4',
            'weight' => '15.4',
        ]);
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->createShipment($request);

        $this->assertNull($response->exception);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can create a Shipment correctly.
     *
     * @return void
     */
    public function testRetrieveShipment()
    {
        CassetteSetup::setupCassette('shipments/retrieve.yml', self::$expireCassetteDays);

        // TODO: Make this dynamic, is that possible with our setup?
        $id = 'shp_e9ec97c21c6e473c9608852c5b46139b';

        $request = Request::create("/shipments/$id", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveShipment($request, $id);

        $viewData = $response->getData();

        $this->assertNull($response->exception);
        $this->assertEquals($id, $viewData['shipment']['id']);
    }

    /**
     * Tests that we return an error correctly when retrieving a Shipment.
     *
     * @return void
     */
    public function testRetrieveShipmentException()
    {
        CassetteSetup::setupCassette('shipments/retrieveException.yml', self::$expireCassetteDays);

        $id = 'bad_id';

        $request = Request::create("/shipments/$id", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveShipment($request, $id);

        $this->assertEquals('The requested resource could not be found.', $response->getSession()->get('error'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we show the shipments page correctly.
     *
     * @return void
     */
    public function testRetrieveShipments()
    {
        CassetteSetup::setupCassette('shipments/retrieveShipments.yml', self::$expireCassetteDays);

        $request = Request::create('/shipments', 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveShipments($request);

        $viewData = $response->getData();

        $this->assertNotNull($viewData['json']);
    }

    /**
     * Tests that we refund a shipment correctly.
     *
     * @return void
     */
    public function testRefundShipment()
    {
        CassetteSetup::setupCassette('shipments/refundShipment.yml', self::$expireCassetteDays);

        // TODO: Make this dynamic, is that possible with our setup?
        $id = 'shp_d9aa52f795f547dc88aac82bae2478e8';

        $request = Request::create("/shipments/$id/refund", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->refundShipment($request, $id);

        $this->assertEquals(
            'Refund submitted! Follow-up with the carrier for more details.',
            $response->getSession()->get('message')
        );
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we buy a shipment correctly.
     *
     * @return void
     */
    public function testBuyShipment()
    {
        CassetteSetup::setupCassette('shipments/buyShipment.yml', self::$expireCassetteDays);

        // TODO: Make this dynamic, is that possible with our setup?
        $id = 'shp_d9aa52f795f547dc88aac82bae2478e8';
        $rateId = 'rate_7e78c782520a44dd9e915d96dedb5408'; // GroundAdvantage

        $request = Request::create("/shipments/$id/buy", 'GET', ['rate_id' => $rateId]);
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->buyShipment($request, $id);

        $this->assertEquals('Shipment bought!', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we buy a stamp for a Shipment correctly.
     *
     * @return void
     */
    public function testBuyStamp()
    {
        CassetteSetup::setupCassette('shipments/buyStamp.yml', self::$expireCassetteDays);

        $request = Request::create('/shipments/stamp', 'POST', [
            'from_name' => 'Jack Sparrow',
            'from_street1' => '388 Townsend St',
            'from_street2' => 'Apt 20',
            'from_city' => 'San Francisco',
            'from_state' => 'CA',
            'from_zip' => '94107',
            'to_name' => 'Elizabeth Swan',
            'to_street1' => '179 N Harbor Dr',
            'to_city' => 'Redondo Beach',
            'to_state' => 'CA',
            'to_zip' => '90277',
        ]);
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->buyStamp($request);

        // TODO: Unfortunately we can't buy a stamp easily with our setup in test because we also check for
        // the first USPS carrier account which requires a prod API key, but then our test would drum up
        // postage fees which we don't want. Assert we get as far as we can in the process.
        $this->assertEquals(
            'This resource requires a production API Key to access.',
            $response->getSession()->get('error')
        );
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we generate QR codes for a shipment correctly.
     *
     * @return void
     */
    public function testGenerateQrCodes()
    {
        CassetteSetup::setupCassette('shipments/generateQrCodes.yml', self::$expireCassetteDays);

        // TODO: Make this dynamic, is that possible with our setup?
        $id = 'shp_d9aa52f795f547dc88aac82bae2478e8';

        $request = Request::create("/shipments/$id/qr-codes", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->generateQrCodes($request, $id);

        $this->assertEquals('QR code generated!', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }
}
