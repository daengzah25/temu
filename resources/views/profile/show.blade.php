@extends('layouts.app')

@section('title', 'Profil - Temu')

@section('content')
<div class="container">
    <div class="card text-center">
        <img src="{{ $user->avatar }}" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 16px; border: 4px solid #3B82F6;">
        <h2>{{ $user->name }}</h2>
        <p class="text-sm text-gray mb">{{ $user->email }}</p>
        <span style="background: {{ $user->role === 'admin' ? '#F59E0B' : ($user->role === 'umkm' ? '#3B82F6' : '#10B981') }}; color: white; padding: 4px 16px; border-radius: 12px; font-size: 12px; font-weight: 600; display: inline-block;">
            {{ strtoupper($user->role) }}
        </span>
    </div>

    @if($user->role === 'umkm' && $user->company)
        <div class="card">
            <h3 class="mb2">🏪 UMKM Saya</h3>
            <div class="flex items-center gap mb2">
                @if($user->company->logo)
                    <img src="{{ $user->company->logo }}" alt="Logo" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                @else
                    <div style="width: 50px; height: 50px; background: #E5E7EB; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-store" style="color: #6B7280;"></i>
                    </div>
                @endif
                <div style="flex: 1;">
                    <h3>{{ $user->company->name }}</h3>
                    <p class="text-sm text-gray">{{ $user->company->category }}</p>
                </div>
            </div>
            <div class="flex gap">
                <a href="{{ route('umkm.dashboard') }}" class="btn" style="flex: 1; background: #3B82F6; color: white; text-decoration: none; text-align: center; padding: 10px;">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="{{ route('umkm.profile.edit') }}" class="btn" style="flex: 1; background: #10B981; color: white; text-decoration: none; text-align: center; padding: 10px;">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>
        </div>
    @endif

    <div class="card">
        <h3 class="mb2">⚙️ Pengaturan</h3>
        <div style="display: grid; gap: 12px;">
            @if($user->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" style="background: #F9FAFB; padding: 16px; border-radius: 8px; text-decoration: none; color: inherit; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-crown" style="font-size: 24px; color: #F59E0B;"></i>
                    <div>
                        <h3>Dashboard Admin</h3>
                        <p class="text-sm text-gray">Kelola UMKM & user</p>
                    </div>
                </a>
            @endif

            @if($user->role === 'umkm')
                <a href="{{ route('products.index') }}" style="background: #F9FAFB; padding: 16px; border-radius: 8px; text-decoration: none; color: inherit; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-box" style="font-size: 24px; color: #3B82F6;"></i>
                    <div>
                        <h3>Produk Saya</h3>
                        <p class="text-sm text-gray">{{ $user->company ? $user->company->products->count() : 0 }} produk</p>
                    </div>
                </a>

                <a href="{{ route('ai-promotion.index') }}" style="background: #F9FAFB; padding: 16px; border-radius: 8px; text-decoration: none; color: inherit; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-robot" style="font-size: 24px; color: #10B981;"></i>
                    <div>
                        <h3>AI Promosi</h3>
                        <p class="text-sm text-gray">Generate konten otomatis</p>
                    </div>
                </a>
            @endif

            @if($user->role === 'visitor')
                <a href="{{ route('bookmarks.index') }}" style="background: #F9FAFB; padding: 16px; border-radius: 8px; text-decoration: none; color: inherit; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-heart" style="font-size: 24px; color: #EF4444;"></i>
                    <div>
                        <h3>Favorit Saya</h3>
                        <p class="text-sm text-gray">{{ $user->bookmarks->count() }} UMKM tersimpan</p>
                    </div>
                </a>

                <a href="{{ route('visitor.nearby') }}" style="background: #F9FAFB; padding: 16px; border-radius: 8px; text-decoration: none; color: inherit; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-search" style="font-size: 24px; color: #3B82F6;"></i>
                    <div>
                        <h3>Cari UMKM</h3>
                        <p class="text-sm text-gray">Temukan UMKM terdekat</p>
                    </div>
                </a>
            @endif
        </div>
    </div>

    <div class="card">
        <h3 class="mb2">📱 Tentang Akun</h3>
        <div class="text-sm" style="line-height: 2;">
            <p><i class="fas fa-calendar" style="width: 20px; color: #6B7280;"></i> Bergabung: {{ $user->created_at->format('d M Y') }}</p>
            <p><i class="fas fa-clock" style="width: 20px; color: #6B7280;"></i> Terakhir login: {{ $user->updated_at->diffForHumans() }}</p>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-block" style="background: #EF4444; color: white;">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </button>
    </form>
</div>
@endsection

@section('bottom-nav')
@if($user->role === 'visitor')
    <nav class="bottom-nav">
        <a href="{{ route('visitor.home') }}">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('visitor.nearby') }}">
            <i class="fas fa-search"></i>
            <span>Cari</span>
        </a>
        <a href="{{ route('bookmarks.index') }}">
            <i class="fas fa-heart"></i>
            <span>Favorit</span>
        </a>
        <a href="{{ route('profile.show') }}" class="active">
            <i class="fas fa-user"></i>
            <span>Profil</span>
        </a>
    </nav>
@elseif($user->role === 'umkm')
    <nav class="bottom-nav">
        <a href="{{ route('umkm.dashboard') }}">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('products.index') }}">
            <i class="fas fa-box"></i>
            <span>Produk</span>
        </a>
        <a href="{{ route('ai-promotion.index') }}">
            <i class="fas fa-robot"></i>
            <span>AI Promosi</span>
        </a>
        <a href="{{ route('profile.show') }}" class="active">
            <i class="fas fa-user"></i>
            <span>Profil</span>
        </a>
    </nav>
@elseif($user->role === 'admin')
    <nav class="bottom-nav">
        <a href="{{ route('admin.dashboard') }}">
            <i class="fas fa-crown"></i>
            <span>Admin</span>
        </a>
        <a href="{{ route('admin.companies') }}">
            <i class="fas fa-list"></i>
            <span>UMKM</span>
        </a>
        <a href="{{ route('admin.users.index') }}">
            <i class="fas fa-users"></i>
            <span>User</span>
        </a>
        <a href="{{ route('profile.show') }}" class="active">
            <i class="fas fa-user"></i>
            <span>Profil</span>
        </a>
    </nav>
@endif
@endsection
