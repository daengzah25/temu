@extends('layouts.app')

@section('title', 'Admin Dashboard - Temu')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="card" style="background: #D1FAE5; border-left: 4px solid #10B981;">
            <p style="color: #065F46;">{{ session('success') }}</p>
        </div>
    @endif

    <div class="card">
        <h2><i class="fas fa-crown" style="color: #F59E0B;"></i> Dashboard Admin</h2>
        <p class="text-sm text-gray">Kelola pendaftaran UMKM dan user</p>
    </div>

    <div class="card">
        <h3 class="mb2">📊 Ringkasan</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div style="background: #FEF3C7; padding: 16px; border-radius: 8px;">
                <p class="text-sm text-gray">Menunggu Approval</p>
                <h2 style="color: #F59E0B; margin: 4px 0;">{{ $stats['pending'] }}</h2>
            </div>
            <div style="background: #D1FAE5; padding: 16px; border-radius: 8px;">
                <p class="text-sm text-gray">UMKM Aktif</p>
                <h2 style="color: #10B981; margin: 4px 0;">{{ $stats['approved'] }}</h2>
            </div>
            <div style="background: #FEE2E2; padding: 16px; border-radius: 8px;">
                <p class="text-sm text-gray">Ditolak Hari Ini</p>
                <h2 style="color: #EF4444; margin: 4px 0;">{{ $stats['rejected'] }}</h2>
            </div>
            <div style="background: #EFF6FF; padding: 16px; border-radius: 8px;">
                <p class="text-sm text-gray">Total User</p>
                <h2 style="color: #3B82F6; margin: 4px 0;">{{ $stats['total_users'] }}</h2>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="flex justify-between items-center mb2">
            <h3>🔔 UMKM Menunggu Approval ({{ $pendingCompanies->count() }})</h3>
            <a href="{{ route('admin.companies', ['status' => 'pending']) }}" class="text-blue text-sm">Lihat Semua →</a>
        </div>

        @forelse($pendingCompanies as $company)
            <div class="card" style="background: #FFFBEB; border-left: 4px solid #F59E0B; margin-bottom: 12px;">
                <div class="flex items-center gap">
                    @if($company->logo)
                        <img src="{{ $company->logo }}" alt="Logo" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                    @else
                        <div style="width: 50px; height: 50px; background: #E5E7EB; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-store" style="color: #6B7280;"></i>
                        </div>
                    @endif
                    <div style="flex: 1;">
                        <h3>{{ $company->name }}</h3>
                        <p class="text-sm text-gray mb">
                            <i class="fas fa-map-marker-alt"></i> {{ Str::limit($company->address, 40) }}
                        </p>
                        <p class="text-sm text-gray">
                            <i class="fas fa-clock"></i> Daftar: {{ $company->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                <div class="flex gap mt2">
                    <a href="{{ route('admin.company.show', $company->id) }}" class="btn" style="flex: 1; background: #3B82F6; color: white; padding: 8px;">
                        <i class="fas fa-eye"></i> Review
                    </a>
                </div>
            </div>
        @empty
            <p class="text-center text-gray" style="padding: 24px;">Tidak ada UMKM yang menunggu approval</p>
        @endforelse
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-block" style="background: #6B7280; color: white;">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </button>
    </form>
</div>
@endsection

@section('bottom-nav')
<nav class="bottom-nav">
    <a href="{{ route('admin.dashboard') }}" class="active">
        <i class="fas fa-crown"></i>
        <span>Admin</span>
    </a>
    <a href="{{ route('admin.companies', ['status' => 'pending']) }}">
        <i class="fas fa-list"></i>
        <span>UMKM</span>
    </a>
    <a href="{{ route('admin.users.index') }}">
        <i class="fas fa-users"></i>
        <span>User</span>
    </a>
    <a href="{{ route('profile.show') }}">
        <i class="fas fa-user"></i>
        <span>Profil</span>
    </a>
</nav>
@endsection
