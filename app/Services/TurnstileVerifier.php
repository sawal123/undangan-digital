<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TurnstileVerifier
{
    public function verify(Request $request): bool
    {
        if (! config('security.turnstile.enabled')) {
            return true;
        }

        $token = $request->input('cf-turnstile-response') ?: $request->input('turnstile_response');
        $secret = config('security.turnstile.secret_key');

        if (blank($token) || blank($secret)) {
            return false;
        }

        try {
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);

            return $response->json('success') === true;
        } catch (\Throwable $exception) {
            Log::warning('Turnstile verification failed.', ['error' => $exception->getMessage()]);

            return false;
        }
    }
}
