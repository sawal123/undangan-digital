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
        $data = Data::where('user_id', Auth::user()->id)->first();
        if ($request->routeIs('dashboard.logout') || $request->routeIs('dashboard.data.store')) {
            return $next($request);
        }
       
        if ($request->routeIs('dashboard.setup')) {
            // Jika data sudah ada (setup terpenuhi), redirect ke halaman lain (misalnya dashboard utama)
            if ($data !== null) {
                return redirect()->to('dashboard');
            }
        } else {
            // Jika bukan akses ke setup, tapi data belum ada, redirect ke halaman setup
            if ($data === null) {
                return redirect()->to('dashboard/setup');
            }
        }return $next($request);
    }
}
