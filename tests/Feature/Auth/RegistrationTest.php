<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertSee('Register');
    }

    public function test_new_users_can_register(): void
    {
        $this->post(route('register.store'), [
            'nama' => 'Test User',
            'email' => 'test@example.com',
            'whatsapp' => '628123456789',
            'password' => 'password',
        ])->assertRedirect('/dashboard/setup');

        $user = User::where('email', 'test@example.com')->firstOrFail();

        $this->assertTrue(Hash::check('password', $user->password));
        $this->assertAuthenticated();
    }
}
