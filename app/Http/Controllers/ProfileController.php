<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Tampilkan profil user
    public function show()
    {
        $user = Auth::user();

        // Load company jika UMKM
        if ($user->role === 'umkm') {
            $user->load('company');
        }

        return view('profile.show', compact('user'));
    }
}
