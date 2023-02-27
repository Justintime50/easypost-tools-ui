<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\ParcelController;
use Illuminate\Http\Request;
use Tests\TestCase;

class ParcelControllerTest extends TestCase
{
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
}
