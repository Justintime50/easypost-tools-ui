<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use VCRAccessories\CassetteSetup;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the testing environment for this file.
     */
    public static function setUpBeforeClass(): void
    {
        CassetteSetup::setupVcrTests();
        self::$controller = new SearchController();
    }

    /**
     * Tests that we retrieve a record by ID correctly.
     *
     * @return void
     */
    public function testShowRecord()
    {
        CassetteSetup::setupCassette('search/showRecord.yml', self::$expireCassetteDays);

        // TODO: Make this dynamic, is that possible with our setup?
        $request = Request::create('/search', 'POST', ['id' => 'adr_04cd8db376af11efb060ac1f6bc53342']);
        $request->setLaravelSession(session()->driver());
        $request->session()->put(['apiKey' => self::$testApiKey]);
        $response = self::$controller->searchRecord($request);

        $viewData = $response->getData();

        $this->assertNotNull($viewData['json']);
    }
}
