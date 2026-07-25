<?php

namespace Tests\Feature;

use App\Livewire\AdminDemo\UserDemo;
use App\Models\AuthActivityLog;
use App\Models\Data;
use App\Models\User;
use App\Services\AuthActivityLogger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthSecurityMonitoringTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        foreach ([
            'login-ip:127.0.0.1',
            'register-ip-hour:127.0.0.1',
            'register-ip-day:127.0.0.1',
            'login-email-ip:audit@example.com|127.0.0.1',
        ] as $key) {
            RateLimiter::clear($key);
        }
    }

    public function test_login_berhasil_tercatat(): void
    {
        $user = $this->userWithRole('User');
        Data::factory()->for($user)->create();

        $this->post(route('login.auth'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect();

        $this->assertDatabaseHas('auth_activity_logs', [
            'user_id' => $user->id,
            'event_type' => AuthActivityLog::EVENT_LOGIN_SUCCESS,
            'status' => 'success',
        ]);
    }

    public function test_login_gagal_tercatat_tanpa_menyimpan_password(): void
    {
        $user = User::factory()->create();

        $this->post(route('login.auth'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertSessionHas('error');

        $log = AuthActivityLog::where('event_type', AuthActivityLog::EVENT_LOGIN_FAILED)->firstOrFail();

        $this->assertSame($user->email, $log->email);
        $this->assertStringNotContainsString('wrong-password', json_encode($log->metadata));
    }

    public function test_logout_tercatat(): void
    {
        $user = $this->userWithRole('User');
        Data::factory()->for($user)->create();

        $this->actingAs($user)->post(route('dashboard.logout'))->assertRedirect('/');

        $this->assertDatabaseHas('auth_activity_logs', [
            'user_id' => $user->id,
            'event_type' => AuthActivityLog::EVENT_LOGOUT,
        ]);
    }

    public function test_registrasi_tercatat(): void
    {
        $this->post(route('register.store'), $this->registrationPayload())->assertRedirect(route('verification.notice'));

        $user = User::where('email', 'audit@example.com')->firstOrFail();

        $this->assertDatabaseHas('auth_activity_logs', [
            'user_id' => $user->id,
            'event_type' => AuthActivityLog::EVENT_REGISTER,
        ]);
    }

    public function test_user_belum_verified_dibatasi_dari_fitur_sensitif(): void
    {
        $user = $this->userWithRole('User', ['email_verified_at' => null]);

        $this->actingAs($user)
            ->get(route('dashboard.setup'))
            ->assertRedirect(route('verification.notice'));
    }

    public function test_email_verification_membuka_akses(): void
    {
        $user = $this->userWithRole('User', ['email_verified_at' => null]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->actingAs($user)->get($verificationUrl)->assertRedirect();

        $this->actingAs($user)
            ->get(route('dashboard.setup'))
            ->assertOk();
    }

    public function test_login_rate_limit_menghasilkan_http_429(): void
    {
        config(['security.login_failed_max_per_email_ip' => 1]);
        $user = User::factory()->create();

        $payload = ['email' => $user->email, 'password' => 'wrong-password'];

        $this->post(route('login.auth'), $payload)->assertSessionHas('error');
        $this->post(route('login.auth'), $payload)->assertStatus(429);
    }

    public function test_registrasi_rate_limit_bekerja(): void
    {
        config(['security.register_per_ip_hour' => 1, 'security.register_per_ip_day' => 10]);

        $this->post(route('register.store'), $this->registrationPayload())
            ->assertRedirect(route('verification.notice'));

        $this->app['auth']->guard()->logout();

        $this->post(route('register.store'), $this->registrationPayload([
            'email' => 'rate-limited@example.com',
        ]))->assertStatus(429);
    }

    public function test_banyak_login_gagal_menaikkan_risk_level(): void
    {
        config([
            'security.login_failed_max_per_email_ip' => 50,
            'security.login_attempts_per_ip' => 100,
        ]);

        $user = User::factory()->create();

        for ($i = 0; $i < 11; $i++) {
            $this->post(route('login.auth'), [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);
        }

        $this->assertTrue(
            AuthActivityLog::where('event_type', AuthActivityLog::EVENT_LOGIN_FAILED)
                ->whereIn('risk_level', [AuthActivityLog::RISK_HIGH, AuthActivityLog::RISK_CRITICAL])
                ->exists()
        );
    }

    public function test_ownership_violation_tercatat(): void
    {
        $user = $this->userWithRole('User');
        Data::factory()->for($user)->create();

        $other = $this->userWithRole('User');
        $otherData = Data::factory()->for($other)->create();

        $this->actingAs($user)
            ->get(route('dashboard.undangan.kelola', $otherData->uid))
            ->assertNotFound();

        $this->assertDatabaseHas('auth_activity_logs', [
            'user_id' => $user->id,
            'event_type' => AuthActivityLog::EVENT_OWNERSHIP_VIOLATION,
            'risk_level' => AuthActivityLog::RISK_HIGH,
        ]);
    }

    public function test_akun_suspended_tidak_dapat_login(): void
    {
        $user = $this->userWithRole('User', ['suspended_at' => now(), 'suspension_reason' => 'review']);

        $this->post(route('login.auth'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertStatus(403);

        $this->assertGuest();
    }

    public function test_akun_yang_diaktifkan_kembali_dapat_login(): void
    {
        $owner = $this->userWithRole('Owner');
        $user = $this->userWithRole('User', ['suspended_at' => now(), 'suspension_reason' => 'review']);
        Data::factory()->for($user)->create();

        Livewire::actingAs($owner)
            ->test(UserDemo::class)
            ->call('reactivate', $user->id, 'review_done');

        $this->app['auth']->guard()->logout();

        $this->post(route('login.auth'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect();

        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_dapat_mencabut_seluruh_session_user(): void
    {
        $owner = $this->userWithRole('Owner');
        $user = $this->userWithRole('User', ['remember_token' => 'old-token']);

        Livewire::actingAs($owner)
            ->test(UserDemo::class)
            ->call('revokeSessions', $user->id, 'security_review');

        $this->assertNotSame('old-token', $user->fresh()->remember_token);
        $this->assertDatabaseHas('auth_activity_logs', [
            'user_id' => $user->id,
            'status' => 'session_revoked',
        ]);
    }

    public function test_user_biasa_tidak_dapat_membuka_log_keamanan(): void
    {
        $user = $this->userWithRole('User');

        $this->actingAs($user)
            ->get(route('admin.security'))
            ->assertForbidden();

        $this->assertDatabaseHas('auth_activity_logs', [
            'user_id' => $user->id,
            'event_type' => AuthActivityLog::EVENT_ADMIN_ACCESS_DENIED,
        ]);
    }

    public function test_metadata_sensitif_dimasking(): void
    {
        $request = Request::create('/audit-test', 'POST');
        $request->setLaravelSession($this->app['session.store']);

        app(AuthActivityLogger::class)->log(
            AuthActivityLog::EVENT_REGISTER,
            metadata: [
                'password' => 'secret-password',
                'password_confirmation' => 'secret-password',
                'token' => 'reset-token',
                'otp' => '123456',
                'Authorization' => 'Bearer secret',
                'Cookie' => 'session=secret',
                'safe' => 'visible',
            ],
            request: $request
        );

        $metadata = json_encode(AuthActivityLog::firstOrFail()->metadata);

        $this->assertStringContainsString('visible', $metadata);
        $this->assertStringNotContainsString('secret-password', $metadata);
        $this->assertStringNotContainsString('reset-token', $metadata);
        $this->assertStringNotContainsString('123456', $metadata);
        $this->assertStringNotContainsString('Bearer secret', $metadata);
        $this->assertStringNotContainsString('session=secret', $metadata);
    }

    public function test_command_prune_menghapus_log_lama_sesuai_retensi(): void
    {
        config([
            'security.auth_log_retention_days' => 90,
            'security.auth_high_risk_retention_days' => 365,
        ]);

        AuthActivityLog::create($this->logPayload(['risk_level' => AuthActivityLog::RISK_LOW, 'occurred_at' => now()->subDays(91)]));
        AuthActivityLog::create($this->logPayload(['risk_level' => AuthActivityLog::RISK_HIGH, 'occurred_at' => now()->subDays(91)]));
        AuthActivityLog::create($this->logPayload(['risk_level' => AuthActivityLog::RISK_HIGH, 'occurred_at' => now()->subDays(366)]));

        $this->artisan('security:prune-auth-logs')->assertExitCode(0);

        $this->assertSame(1, AuthActivityLog::count());
        $this->assertSame(AuthActivityLog::RISK_HIGH, AuthActivityLog::first()->risk_level);
    }

    public function test_captcha_gagal_menolak_request_ketika_aktif(): void
    {
        config(['security.turnstile.enabled' => true, 'security.turnstile.secret_key' => 'test-secret']);
        Http::fake(['challenges.cloudflare.com/*' => Http::response(['success' => false])]);

        $this->post(route('register.store'), $this->registrationPayload([
            'cf-turnstile-response' => 'bad-token',
        ]))->assertSessionHasErrors('captcha');
    }

    public function test_captcha_tidak_mengganggu_saat_dinonaktifkan(): void
    {
        config(['security.turnstile.enabled' => false]);

        $this->post(route('register.store'), $this->registrationPayload([
            'email' => 'captcha-disabled@example.com',
        ]))->assertRedirect(route('verification.notice'));

        $this->assertDatabaseHas('users', ['email' => 'captcha-disabled@example.com']);
    }

    public function test_disposable_email_hanya_ditolak_ketika_konfigurasi_aktif(): void
    {
        config([
            'security.block_disposable_email' => true,
            'security.disposable_domains' => ['mailinator.com'],
        ]);

        $this->post(route('register.store'), $this->registrationPayload([
            'email' => 'audit@mailinator.com',
        ]))->assertSessionHasErrors('email');

        config(['security.block_disposable_email' => false]);

        $this->post(route('register.store'), $this->registrationPayload([
            'email' => 'allowed@mailinator.com',
        ]))->assertRedirect(route('verification.notice'));

        $this->assertDatabaseHas('users', ['email' => 'allowed@mailinator.com']);
    }

    public function test_nama_atau_email_acak_tidak_otomatis_membuat_akun_suspended(): void
    {
        $this->post(route('register.store'), $this->registrationPayload([
            'nama' => 'x',
            'email' => 'x918273645@example.com',
        ]))->assertRedirect(route('verification.notice'));

        $user = User::where('email', 'x918273645@example.com')->firstOrFail();

        $this->assertNull($user->suspended_at);
        $this->assertNotSame(AuthActivityLog::RISK_CRITICAL, $user->security_risk_level);
    }

    private function userWithRole(string $role, array $attributes = []): User
    {
        Role::findOrCreate($role);

        $user = User::factory()->create($attributes);
        $user->assignRole($role);

        return $user;
    }

    private function registrationPayload(array $overrides = []): array
    {
        return array_merge([
            'nama' => 'Audit User',
            'email' => 'audit@example.com',
            'whatsapp' => '628123456789',
            'password' => 'password',
        ], $overrides);
    }

    private function logPayload(array $overrides = []): array
    {
        return array_merge([
            'event_type' => AuthActivityLog::EVENT_LOGIN_FAILED,
            'status' => 'failed',
            'risk_level' => AuthActivityLog::RISK_LOW,
            'occurred_at' => now(),
        ], $overrides);
    }
}
