<?php

namespace App\Http\Middleware;

use App\Models\AuthActivityLog;
use App\Services\AuthActivityLogger;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAdminAccessDenied
{
    public function __construct(private readonly AuthActivityLogger $logger) {}

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->hasRole('Owner')) {
            $this->logger->log(
                AuthActivityLog::EVENT_ADMIN_ACCESS_DENIED,
                'denied',
                $user,
                metadata: ['route' => optional($request->route())->getName()],
                request: $request,
                riskLevel: AuthActivityLog::RISK_HIGH,
                riskReasons: ['user non-admin mencoba membuka halaman admin']
            );

            abort(403);
        }

        return $next($request);
    }
}
