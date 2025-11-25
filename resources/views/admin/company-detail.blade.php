@extends('layouts.app')

@section('title', 'Review UMKM - Admin')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="card" style="background: #D1FAE5; border-left: 4px solid #10B981;">
                <p style="color: #065F46;">{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="card" style="background: #FEE2E2; border-left: 4px solid #EF4444;">
                @foreach ($errors->all() as $error)
                    <p style="color: #991B1B; font-size: 14px;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="card">
            <a href="{{ route('admin.dashboard') }}" class="text-blue text-sm mb2" style="display: inline-block;">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h2>Review Pendaftaran UMKM</h2>
        </div>

        <div class="card">
            @if ($company->logo)
                <img src="{{ $company->logo }}" alt="Logo"
                    style="width: 100%; max-width: 200px; height: 200px; object-fit: cover; border-radius: 12px; margin: 0 auto 16px; display: block;">
            @endif

            <h3 class="mb2">📋 Informasi UMKM</h3>
            <div class="text-sm" style="line-height: 2;">
                <p><strong>Nama Usaha:</strong> {{ $company->name }}</p>
                <p><strong>Kategori:</strong> {{ $company->category }}</p>
                <p><strong>Deskripsi:</strong> {{ $company->description ?? '-' }}</p>
                <p><strong>Alamat:</strong> {{ $company->address }}</p>
                <p><strong>Koordinat:</strong> {{ $company->latitude }}, {{ $company->longitude }}</p>
                <p><strong>WhatsApp:</strong> {{ $company->whatsapp }}</p>
                <p><strong>Jam Operasional:</strong> {{ $company->operating_hours ?? '-' }}</p>
            </div>
        </div>

        <div class="card">
            <h3 class="mb2">👤 Pemilik</h3>
            <div class="flex items-center gap">
                <img src="{{ $company->user->avatar }}" alt="Avatar"
                    style="width: 50px; height: 50px; border-radius: 50%;">
                <div>
                    <p><strong>{{ $company->user->name }}</strong></p>
                    <p class="text-sm text-gray">{{ $company->user->email }}</p>
                    <p class="text-sm text-gray">Daftar: {{ $company->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        @if ($company->status === 'pending')
            <div class="card" style="background: #D1FAE5;">
                <h3 class="mb2" style="color: #065F46;"><i class="fas fa-check-circle"></i> Setujui Pendaftaran</h3>
                <form action="{{ route('admin.company.approve', $company->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-block" style="background: #10B981; color: white;">
                        ✓ Setujui UMKM Ini
                    </button>
                </form>
            </div>

            <div class="card" style="background: #FEE2E2;">
                <h3 class="mb2" style="color: #991B1B;"><i class="fas fa-times-circle"></i> Tolak Pendaftaran</h3>
                <form action="{{ route('admin.company.reject', $company->id) }}" method="POST">
                    @csrf
                    <label>Alasan Penolakan (Wajib) *</label>
                    <textarea name="reason" rows="3"
                        placeholder="Contoh: Alamat tidak lengkap. Mohon sertakan nama jalan, nomor, dan kode pos." required></textarea>
                    <button type="submit" class="btn btn-block" style="background: #EF4444; color: white;">
                        ✗ Tolak Pendaftaran
                    </button>
                </form>
            </div>
        @else
            <div class="card text-center">
                <span
                    style="background: {{ $company->status === 'approved' ? '#D1FAE5' : '#FEE2E2' }}; color: {{ $company->status === 'approved' ? '#065F46' : '#991B1B' }}; padding: 8px 16px; border-radius: 12px; font-weight: 600;">
                    Status: {{ strtoupper($company->status) }}
                </span>
                @if ($company->rejection_reason)
                    <p class="text-sm mt2">Alasan: {{ $company->rejection_reason }}</p>
                @endif
            </div>
        @endif

        <nav class="bottom-nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-crown"></i>
                <span>Admin</span>
            </a>
            <a href="{{ route('admin.companies') }}"
                class="{{ request()->routeIs('admin.companies*') || request()->routeIs('admin.company.show') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                <span>UMKM</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>User</span>
            </a>
            <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">
                <i class="fas fa-user"></i>
                <span>Profil</span>
            </a>
        </nav>
    </div>
@endsection
