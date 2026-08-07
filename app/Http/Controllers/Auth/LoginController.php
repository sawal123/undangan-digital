<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AuthActivityLog;
use App\Models\Data;
use App\Models\User;
use App\Services\AuthActivityLogger;
use App\Services\TurnstileVerifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index()
    {
        $nonce = bin2hex(random_bytes(16));
        if (! Auth::user()) {
            return view('page.auth.login', ['nonce' => $nonce]);
        } else {
            return redirect()->to('/');
        }
    }

    public function login(LoginRequest $request, AuthActivityLogger $activityLogger, TurnstileVerifier $turnstile)
    {
        $email = Str::lower((string) $request->input('email'));
        $ipKey = 'login-ip:' . $request->ip();
        $emailIpKey = 'login-email-ip:' . $email . '|' . $request->ip();
        $message = 'Email atau kata sandi tidak sesuai.';

        if (
            RateLimiter::tooManyAttempts($ipKey, (int) config('security.login_attempts_per_ip', 20))
            || RateLimiter::tooManyAttempts($emailIpKey, (int) config('security.login_failed_max_per_email_ip', 5))
        ) {
            $activityLogger->log(
                AuthActivityLog::EVENT_RATE_LIMIT_TRIGGERED,
                'blocked',
                email: $email,
                metadata: ['limiter' => 'login'],
                request: $request,
                riskLevel: AuthActivityLog::RISK_HIGH,
                riskReasons: ['login rate limit terpicu']
            );

            session()->flash('error', $message);

            return response()->view('page.auth.login', ['nonce' => bin2hex(random_bytes(16))], 429);
        }

        RateLimiter::hit($ipKey, (int) config('security.login_attempts_decay_seconds', 900));

        if (RateLimiter::attempts($emailIpKey) >= 3 && ! $turnstile->verify($request)) {
            return back()
                ->withErrors(['captcha' => 'Verifikasi keamanan gagal.'])
                ->withInput($request->only('email'));
        }

        $candidate = User::query()->where('email', $email)->first();

        if ($candidate?->isSuspended() && Hash::check((string) $request->input('password'), $candidate->password)) {
            $activityLogger->log(
                AuthActivityLog::EVENT_LOGIN_FAILED,
                'suspended',
                $candidate,
                $email,
                request: $request,
                riskLevel: AuthActivityLog::RISK_HIGH,
                riskReasons: ['akun sedang ditangguhkan']
            );

            session()->flash('error', $message);

            return response()->view('page.auth.login', ['nonce' => bin2hex(random_bytes(16))], 403);
        }

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($emailIpKey, (int) config('security.login_failed_decay_seconds', 60));

            return back()->with('error', $message)->withInput($request->only('email'));
        }

        RateLimiter::clear($emailIpKey);
        $request->session()->regenerate();

        if (auth()->user()->hasRole('Owner')) {
            return redirect()->to('/admin');
        }

        if (auth()->user()->hasRole('User')) {
            $data = Data::where('user_id', Auth::user()->id)->latest()->first();

            if ($data) {
                if (blank($data->uid)) {
                    $data->update(['uid' => Data::generateUniqueUid()]);
                }

                return redirect()->route('dashboard.undangan.kelola', $data->uid);
            } else {
                return redirect()->route('dashboard.setup');
            }
        }

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Fungsi untuk logout

        // Menghapus session dan regenerasi untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login atau home setelah logout
        return redirect('/')->with('success', 'You have successfully logged out.');
    }
}
