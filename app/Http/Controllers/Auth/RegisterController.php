<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.auth.register');
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
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'whatsapp' => 'required|numeric',
            'password' => 'required|string'
        ]);
        DB::beginTransaction();
        try {
            $roleUser = Role::firstOrCreate(['name' => 'User']);
            $user =  User::create([
                'name' => $validasi['nama'],
                'email' => $validasi['email'],
                'avatar' => 'images/default-avatar.png',
                'phone' => $validasi['whatsapp'],
                'password' => $validasi['password']
            ]);
            $user->assignRole($roleUser);
            DB::commit();
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->to('/');
        } catch (ValidationException $e) {
            // Kembalikan pesan error validasi unik untuk email
            return redirect()->back()->with('message', 'Email tersebut sudah terdaftar, gunakan email yang lain.');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
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
