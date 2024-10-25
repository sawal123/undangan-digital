<?php

namespace App\Http\Middleware;

use App\Models\Data;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSetupComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('dashboard.setup') || $request->routeIs('dashboard.logout')) {
            return $next($request);
        }
        $data = Data::where('user_id', Auth::user()->id)->first();
        if ($data == null) {

            return redirect()->to('dashboard/setup');
        } return $next($request);
    }
}
