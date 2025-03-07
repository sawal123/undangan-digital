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
use App\Models\Data;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
   public function index()
   {
      $nonce = bin2hex(random_bytes(16));
      if (!Auth::user()) {
         return view('page.auth.login',['nonce'=>$nonce]);
      } else {
         return redirect()->to('/');
      }
   }

   public function login(LoginRequest $request): RedirectResponse
   {
      $request->authenticate();
      $request->session()->regenerate();

      if (auth()->user()->hasRole('Owner')) {
         return redirect()->to('/admin');
      }
      if (auth()->user()->hasRole('User')) {
         if (Data::find(Auth::user()->id)) {
            return redirect()->route('dashboard.undangan.kelola.index');
         } else {
            return redirect()->route('dashboard.setup');
         }
      }
      // Default redirect jika bukan Owner
      // return redirect()->intended(RouteServiceProvider::HOME);
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
