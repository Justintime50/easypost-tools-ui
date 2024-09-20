<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\InsuranceController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use VCRAccessories\CassetteSetup;

class InsuranceControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the testing environment for this file.
     */
    public static function setUpBeforeClass(): void
    {
        CassetteSetup::setupVcrTests();
        self::$controller = new InsuranceController();
    }

    /**
     * Cleanup the testing environment once finished.
     */
    public static function tearDownAfterClass(): void
    {
        CassetteSetup::teardownVcrTests();
    }

    /**
     * Tests that we can create a Insurance correctly.
     *
     * @return void
     */
    public function testCreateInsurance()
    {
        CassetteSetup::setupCassette('insurances/create.yml', self::$expireCassetteDays);

        $request = Request::create('/insurances', 'POST', [
            'tracking_code' => 'EZ1000000001',
            'carrier' => 'USPS',
            'amount' => '100',
        ]);
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->createInsurance($request);

        $this->assertNull($response->exception);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can create a Insurance correctly.
     *
     * @return void
     */
    public function testRetrieveInsurance()
    {
        CassetteSetup::setupCassette('insurances/retrieve.yml', self::$expireCassetteDays);

        // TODO: Make this dynamic, is that possible with our setup?
        $id = 'ins_b38accabc71b4cc7a294943f9c75faa3';

        $request = Request::create("/insurances/$id", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveInsurance($request, $id);

        $viewData = $response->getData();

        $this->assertNull($response->exception);
        $this->assertEquals($id, $viewData['json']['id']);
    }

    /**
     * Tests that we return an error correctly when retrieving a Insurance.
     *
     * @return void
     */
    public function testRetrieveInsuranceException()
    {
        CassetteSetup::setupCassette('insurances/retrieveException.yml', self::$expireCassetteDays);

        $id = 'bad_id';

        $request = Request::create("/insurances/$id", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveInsurance($request, $id);

        $this->assertEquals('The requested resource could not be found.', $response->getSession()->get('error'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we show the insurances page correctly.
     *
     * @return void
     */
    public function testRetrieveInsurances()
    {
        CassetteSetup::setupCassette('insurances/retrieveInsurances.yml', self::$expireCassetteDays);

        $request = Request::create('/insurances', 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveInsurances($request);

        $viewData = $response->getData();

        $this->assertNotNull($viewData['json']);
    }
}
