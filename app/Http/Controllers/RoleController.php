<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    // Tampilkan halaman pilih role
    public function showSelectRole()
    {
        $user = Auth::user();

        // Jika sudah punya role selain visitor, redirect
        if ($user->role && $user->role !== 'visitor') {
            return $this->redirectByRole($user->role);
        }

        return view('select-role');
    }

    // Proses pilihan role
    public function updateRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:umkm,visitor'
        ]);

        $user = Auth::user();
        $user->role = $request->role;
        $user->save();

        // Redirect sesuai role
        if ($request->role === 'umkm') {
            return redirect()->route('umkm.register.form')
                ->with('success', 'Silakan lengkapi data UMKM Anda');
        }

        return redirect()->route('home')
            ->with('success', 'Selamat datang di Temu!');
    }

    // Helper redirect by role
    private function redirectByRole($role)
    {
        return match($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'umkm' => redirect()->route('umkm.dashboard'),
            'visitor' => redirect()->route('visitor.home'),
            default => redirect()->route('home'),
        };
    }
}
