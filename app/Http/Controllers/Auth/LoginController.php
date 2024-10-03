<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Lockout;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
   public function index()
   {
      return view('page.auth.login');
   }

   public function login(LoginRequest $request): RedirectResponse
   {
      // dd($request->email);
      $request->authenticate();
      $request->session()->regenerate();
     

      if (auth()->user()->hasRole('Owner')) {
         return redirect()->to('/admin');
      }
      // Default redirect jika bukan Owner
      return redirect()->intended(RouteServiceProvider::HOME);
   }
}
