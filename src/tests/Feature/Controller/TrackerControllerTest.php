<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\TrackerController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use VCRAccessories\CassetteSetup;

class TrackerControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the testing environment for this file.
     */
    public static function setUpBeforeClass(): void
    {
        CassetteSetup::setupVcrTests();
        self::$controller = new TrackerController();
    }

    /**
     * Cleanup the testing environment once finished.
     */
    public static function tearDownAfterClass(): void
    {
        CassetteSetup::teardownVcrTests();
    }

    /**
     * Tests that we can create a Tracker correctly.
     *
     * @return void
     */
    public function testCreateTracker()
    {
        CassetteSetup::setupCassette('trackers/create.yml', self::$expireCassetteDays);

        $request = Request::create('/trackers', 'POST', [
            'tracking_code' => 'EZ1000000001',
            'carrier' => 'USPS',
        ]);
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->createTracker($request);

        $this->assertNull($response->exception);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we return an error correctly when creating a Tracker.
     *
     * @return void
     */
    public function testCreateTrackerException()
    {
        CassetteSetup::setupCassette('trackers/createException.yml', self::$expireCassetteDays);

        $request = Request::create('/trackers', 'POST', [
            'tracking_code' => 'EZ1000000001',
            'carrier' => 'USPS',
        ]);
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$prodApiKey]); // send test mode tracker in prod mode
        $response = self::$controller->createTracker($request);

        $this->assertEquals(
            'The tracking number does not belong to the carrier you specified. Please confirm that both the carrier and tracking number are correct.', // phpcs:ignore
            $response->getSession()->get('error')
        );
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can create a Tracker correctly.
     *
     * @return void
     */
    public function testRetrieveTracker()
    {
        CassetteSetup::setupCassette('trackers/retrieve.yml', self::$expireCassetteDays);

        // TODO: Make this dynamic, is that possible with our setup?
        $id = 'trk_a9b75e9fa3cc48a58abad090376053c7';

        $request = Request::create("/trackers/$id", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveTracker($request, $id);

        $viewData = $response->getData();

        $this->assertNull($response->exception);
        $this->assertEquals($id, $viewData['json']['id']);
    }

    /**
     * Tests that we return an error correctly when retrieving a Tracker.
     *
     * @return void
     */
    public function testRetrieveTrackerException()
    {
        CassetteSetup::setupCassette('trackers/retrieveException.yml', self::$expireCassetteDays);

        $id = 'bad_id';

        $request = Request::create("/trackers/$id", 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveTracker($request, $id);

        $this->assertEquals('The tracker(s) could not be found.', $response->getSession()->get('error'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we show the trackers page correctly.
     *
     * @return void
     */
    public function testRetrieveTrackers()
    {
        CassetteSetup::setupCassette('trackers/retrieveTrackers.yml', self::$expireCassetteDays);

        $request = Request::create('/trackers', 'GET');
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->retrieveTrackers($request);

        $viewData = $response->getData();

        $this->assertNotNull($viewData['json']);
    }
}
