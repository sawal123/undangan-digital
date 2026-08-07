<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = config('services.api.key');

        if (empty($apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'API key tidak dikonfigurasi di server.',
            ], 500);
        }

        $providedKey = $request->header('X-API-Key');

        if (!$providedKey || $providedKey !== $apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. API key tidak valid.',
            ], 401);
        }

        return $next($request);
    }
}
