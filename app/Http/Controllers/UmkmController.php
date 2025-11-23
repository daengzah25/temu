<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    // Tampilkan form registrasi
    public function showRegisterForm()
    {
        $user = Auth::user();

        // Cek apakah sudah punya company
        if ($user->company) {
            return redirect()->route('umkm.dashboard')
                ->with('info', 'Anda sudah terdaftar sebagai UMKM');
        }

        return view('umkm.register');
    }

    // Proses registrasi UMKM
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'whatsapp' => 'required|string|max:20',
            'operating_hours' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // Handle upload logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $logoPath = $file->storeAs('companies', $filename, 'public');
        }

        // Simpan data company
        $company = Company::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'logo' => $logoPath,
            'category' => $request->category,
            'description' => $request->description,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'whatsapp' => $request->whatsapp,
            'operating_hours' => $request->operating_hours,
            'status' => 'pending',
        ]);

        return redirect()->route('umkm.waiting')
            ->with('success', 'Pendaftaran UMKM berhasil! Menunggu persetujuan admin.');
    }

    // Halaman menunggu approval
    public function waiting()
    {
        $user = Auth::user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('umkm.register.form');
        }

        return view('umkm.waiting', compact('company'));
    }

    // Dashboard UMKM (temporary)
    public function dashboard()
    {
        $user = Auth::user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('umkm.register.form');
        }

        if ($company->status !== 'approved') {
            return redirect()->route('umkm.waiting');
        }

        return view('umkm.dashboard', compact('company'));
    }

    // Tampilkan form edit profil
    public function editProfile()
    {
        $user = Auth::user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('umkm.register.form');
        }

        return view('umkm.edit-profile', compact('company'));
    }

    // Update profil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('umkm.register.form');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'whatsapp' => 'required|string|max:20',
            'operating_hours' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle upload logo baru
        $logoPath = $company->logo;
        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }

            $file = $request->file('logo');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $logoPath = $file->storeAs('companies', $filename, 'public');
        }

        // Update data
        $company->update([
            'name' => $request->name,
            'logo' => $logoPath,
            'category' => $request->category,
            'description' => $request->description,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'whatsapp' => $request->whatsapp,
            'operating_hours' => $request->operating_hours,
        ]);

        // Update slug jika nama berubah
        $company->slug = Str::slug($request->name) . '-' . Str::random(6);
        $company->save();

        return redirect()->route('umkm.dashboard')
            ->with('success', 'Profil UMKM berhasil diupdate!');
    }
}
