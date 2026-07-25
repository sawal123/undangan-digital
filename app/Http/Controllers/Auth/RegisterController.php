<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthActivityLog;
use App\Models\User;
use App\Services\AuthActivityLogger;
use App\Services\TurnstileVerifier;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nonce = bin2hex(random_bytes(16));

        return view('page.auth.register', ['nonce' => $nonce]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TurnstileVerifier $turnstile, AuthActivityLogger $activityLogger)
    {
        $hourKey = 'register-ip-hour:'.$request->ip();
        $dayKey = 'register-ip-day:'.$request->ip();

        if (
            RateLimiter::tooManyAttempts($hourKey, (int) config('security.register_per_ip_hour', 3))
            || RateLimiter::tooManyAttempts($dayKey, (int) config('security.register_per_ip_day', 10))
        ) {
            $activityLogger->log(
                AuthActivityLog::EVENT_RATE_LIMIT_TRIGGERED,
                'blocked',
                metadata: ['limiter' => 'register'],
                request: $request,
                riskLevel: AuthActivityLog::RISK_HIGH,
                riskReasons: ['registration rate limit terpicu']
            );

            session()->flash('message', 'Registrasi belum dapat diproses. Silakan coba lagi nanti.');

            return response()->view('page.auth.register', ['nonce' => bin2hex(random_bytes(16))], 429);
        }

        $validasi = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'whatsapp' => 'required|numeric',
            'password' => 'required|string',
        ]);

        $validasi['email'] = Str::lower($validasi['email']);
        $domain = Str::lower(Str::after($validasi['email'], '@'));

        if (config('security.block_disposable_email') && in_array($domain, config('security.disposable_domains', []), true)) {
            $activityLogger->log(
                AuthActivityLog::EVENT_REGISTER,
                'rejected',
                email: $validasi['email'],
                metadata: ['reason' => 'disposable_domain', 'domain' => $domain],
                request: $request,
                riskLevel: AuthActivityLog::RISK_HIGH,
                riskReasons: ['alamat email dari disposable domain yang dikonfigurasi']
            );

            throw ValidationException::withMessages([
                'email' => 'Email tidak dapat digunakan untuk registrasi.',
            ]);
        }

        if (! $turnstile->verify($request)) {
            throw ValidationException::withMessages([
                'captcha' => 'Verifikasi keamanan gagal.',
            ]);
        }

        try {
            $user = DB::transaction(function () use ($validasi) {
                $roleUser = Role::firstOrCreate(['name' => 'User']);
                $user = User::create([
                    'name' => $validasi['nama'],
                    'email' => $validasi['email'],
                    'avatar' => 'images/default-avatar.png',
                    'phone' => $validasi['whatsapp'],
                    'password' => $validasi['password'],
                ]);
                $user->assignRole($roleUser);

                return $user;
            });

            RateLimiter::hit($hourKey, 3600);
            RateLimiter::hit($dayKey, 86400);
            event(new Registered($user));

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('verification.notice');
        } catch (ValidationException $e) {
            // Kembalikan pesan error validasi unik untuk email
            return redirect()->back()->with('message', 'Email tersebut sudah terdaftar, gunakan email yang lain.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
