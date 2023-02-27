<?php

namespace Tests\Feature\Component;

use App\View\Components\Modal;
use Tests\TestCase;

class ModalComponentTest extends TestCase
{
    /**
     * Tests that build a Modal component correctly.
     *
     * @return void
     */
    public function testBuildModalComponent()
    {
        $view = $this->component(Modal::class, [
            'title' => 'Test title',
            'id' => 'test-id',
            'submitButton' => 'Test submit',
        ]);

        $view->assertSee('Test title', false);
        $view->assertSee('test-id', false);
        $view->assertSee('Test submit', false);
    }
}
