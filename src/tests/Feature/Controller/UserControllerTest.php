<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the testing environment for this file.
     */
    public static function setUpBeforeClass(): void
    {
        self::$controller = new UserController();
    }

    /**
     * Tests that we show the account page correctly.
     *
     * @return void
     */
    public function testAccount()
    {
        $user = User::factory()
            ->create();
        $this->actingAs(User::find($user->id));

        $request = Request::create('/update-api-key', 'POST', ['api_key' => '123456']);
        $response = self::$controller->updateApiKey($request);

        $this->assertDatabaseMissing('users', ['api_key' => '123456']); // Ensure we don't store plaintext API keys
        $this->assertEquals('API key updated!', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }
}
