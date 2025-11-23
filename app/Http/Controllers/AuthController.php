<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // Redirect ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user by email atau google_id
            $user = User::where('email', $googleUser->email)
                        ->orWhere('google_id', $googleUser->id)
                        ->first();

            if ($user) {
                // Update data existing user
                $user->update([
                    'google_id' => $googleUser->id,
                    'name' => $googleUser->name,
                    'avatar' => $googleUser->avatar,
                    'email_verified_at' => now(),
                ]);
            } else {
                // Buat user baru
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'email_verified_at' => now(),
                ]);
            }

            // Login
            Auth::login($user);

            // Redirect sesuai role
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'umkm' => $this->redirectUmkm($user),
                'visitor' => redirect()->route('visitor.home'), // FIX: visitor ke home
                default => redirect()->route('select.role'), // Belum pilih role
            };

        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Login gagal: ' . $e->getMessage());
        }
    }

    // Helper redirect UMKM
    private function redirectUmkm($user)
    {
        if (!$user->company) {
            return redirect()->route('umkm.register.form');
        }

        if ($user->company->status !== 'approved') {
            return redirect()->route('umkm.waiting');
        }

        return redirect()->route('umkm.dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
