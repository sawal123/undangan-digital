<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthActivityLog;
use App\Models\User;
use App\Services\AuthActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class GoogleAuthController extends Controller
{
    public function __construct(private AuthActivityLogger $activityLogger) {}

    /**
     * Redirect to Google OAuth
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists by google_id
            $user = User::where('google_id', $googleUser->getId())->first();

            if ($user) {
                // User exists, just login
                Auth::login($user, remember: true);
                $this->activityLogger->log(
                    AuthActivityLog::EVENT_LOGIN,
                    'success',
                    email: $user->email,
                    metadata: ['method' => 'google'],
                    riskLevel: AuthActivityLog::RISK_LOW
                );

                return redirect()->route('dashboard.index');
            }

            // Check if email exists
            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                // Email exists but no google_id, update it
                $existingUser->update([
                    'google_id' => $googleUser->getId(),
                ]);
                Auth::login($existingUser, remember: true);
                $this->activityLogger->log(
                    AuthActivityLog::EVENT_LOGIN,
                    'success',
                    email: $existingUser->email,
                    metadata: ['method' => 'google', 'linked' => true],
                    riskLevel: AuthActivityLog::RISK_LOW
                );

                return redirect()->route('dashboard.index');
            }

            // Create new user
            $newUser = DB::transaction(function () use ($googleUser) {
                $roleUser = Role::firstOrCreate(['name' => 'User']);

                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar() ?? 'images/default-avatar.png',
                    'phone' => 0,
                    'password' => bcrypt(str()->random(32)), // Random password since using OAuth
                ]);

                $user->assignRole($roleUser);

                return $user;
            });

            Auth::login($newUser, remember: true);
            $this->activityLogger->log(
                AuthActivityLog::EVENT_REGISTER,
                'success',
                email: $newUser->email,
                metadata: ['method' => 'google'],
                riskLevel: AuthActivityLog::RISK_LOW
            );

            return redirect()->route('dashboard.index');
        } catch (\Exception $e) {
            Log::error('Google OAuth callback error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.');
        }
    }
}
