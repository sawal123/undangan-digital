<?php

namespace Tests\Feature\Auth;

use App\Models\Data;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response
            ->assertOk()
            ->assertSee('Sign in');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        Role::findOrCreate('User');
        $user = User::factory()->create();
        $user->assignRole('User');
        $data = Data::factory()->for($user)->create();

        $this->post(route('login.auth'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard.undangan.kelola', $data->uid));

        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post(route('login.auth'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertSessionHas('error');

        $this->assertGuest();
    }

    public function test_navigation_menu_can_be_rendered(): void
    {
        Role::findOrCreate('User');
        $user = User::factory()->create();
        $user->assignRole('User');
        Data::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->get('/dashboard');

        $response
            ->assertOk()
            ->assertSee('Daftar Undangan');
    }

    public function test_users_can_logout(): void
    {
        Role::findOrCreate('User');
        $user = User::factory()->create();
        $user->assignRole('User');
        Data::factory()->for($user)->create();

        $this->actingAs($user);

        $this->post(route('dashboard.logout'))->assertRedirect('/');

        $this->assertGuest();
    }
}
