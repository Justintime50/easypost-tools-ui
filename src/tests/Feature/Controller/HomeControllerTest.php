<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * Setup the testing environment for this file.
     */
    public static function setUpBeforeClass(): void
    {
        self::$controller = new HomeController();
    }

    /**
     * Tests that we show the index page correctly.
     *
     * @return void
     */
    public function testIndex()
    {
        $request = Request::create('/', 'GET');
        $response = self::$controller->index($request);

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
        $request = Request::create('/account', 'GET');
        $response = self::$controller->account($request);

        $viewData = $response->getData();

        $this->assertEmpty($viewData);
    }
}
