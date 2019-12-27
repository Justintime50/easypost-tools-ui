<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /**
     * Test if the app page is accessible.
     *
     * @return void
     */
    public function testApp()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/app');
        $response->assertStatus(200);
    }
}
