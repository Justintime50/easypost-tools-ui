<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * Tests that we show the index page correctly.
     *
     * @return void
     */
    public function testIndex()
    {
        $controller = new HomeController();

        $request = Request::create('/', 'GET');
        $response = $controller->index($request);

        $viewData = $response->getData();

        $this->assertEmpty($viewData);
    }

    /**
     * Tests that we show the account page correctly.
     *
     * @return void
     */
    public function testAccount()
    {
        $controller = new HomeController();

        $request = Request::create('/account', 'GET');
        $response = $controller->account($request);

        $viewData = $response->getData();

        $this->assertEmpty($viewData);
    }
}
