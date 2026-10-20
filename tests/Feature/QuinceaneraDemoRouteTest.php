<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuinceaneraDemoRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_quinceanera_route_renders(): void
    {
        $response = $this->get('/demo/temademo.quinceanera');

        $response->assertStatus(200);
        $response->assertSee('tema/quinceanera/assets/profile-abigail.jpg', false);
        $response->assertSee('id="openInvitation"', false);
    }

    public function test_demo_quinceanera_legacy_slug_is_normalized(): void
    {
        $response = $this->get('/demo/quinceanera');

        $response->assertStatus(200);
        $response->assertSee('id="openInvitation"', false);
    }
}
