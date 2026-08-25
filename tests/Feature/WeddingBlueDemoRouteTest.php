<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeddingBlueDemoRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_wedding_blue_route_renders(): void
    {
        $response = $this->get('/demo/temademo.wedding_blue');

        $response->assertStatus(200);
        $response->assertSee('tema/wedding_blue/assets/hero-couple.png', false);
        $response->assertSee('id="rsvpForm"', false);
    }
}
