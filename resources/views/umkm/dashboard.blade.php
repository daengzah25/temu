@extends('layouts.app')

@section('title', 'Dashboard UMKM - Temu')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="card" style="background: #D1FAE5; border-left: 4px solid #10B981;">
            <p style="color: #065F46;">{{ session('success') }}</p>
        </div>
    @endif

    <div class="card">
        <div class="flex items-center gap">
            @if($company->logo)
                <img src="{{ $company->logo }}" alt="Logo" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
            @else
                <div style="width: 60px; height: 60px; background: #E5E7EB; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-store" style="font-size: 24px; color: #6B7280;"></i>
                </div>
            @endif
            <div style="flex: 1;">
                <h2>{{ $company->name }}</h2>
                <p class="text-sm text-gray">{{ $company->category }}</p>
                <span style="background: #D1FAE5; color: #065F46; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                    ✓ APPROVED
                </span>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="mb2">Statistik Ringkas</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div style="background: #EFF6FF; padding: 16px; border-radius: 8px; text-align: center;">
                <p class="text-sm text-gray">Total Produk</p>
                <h2 style="color: #3B82F6; margin: 4px 0;">{{ $company->products->count() }}</h2>
            </div>
            <div style="background: #F0FDF4; padding: 16px; border-radius: 8px; text-align: center;">
                <p class="text-sm text-gray">Promosi AI</p>
                <h2 style="color: #10B981; margin: 4px 0;">0</h2>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="mb2">Menu Cepat</h3>
        <div style="display: grid; gap: 12px;">
            <a href="{{ route('products.index') }}" style="background: #EFF6FF; padding: 16px; border-radius: 8px; text-decoration: none; color: inherit; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-box" style="font-size: 24px; color: #3B82F6;"></i>
                <div>
                    <h3>Kelola Produk</h3>
                    <p class="text-sm text-gray">Tambah, edit, atau hapus produk</p>
                </div>
            </a>
            <a href="{{ route('ai-promotion.index') }}" style="background: #F0FDF4; padding: 16px; border-radius: 8px; text-decoration: none; color: inherit; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-robot" style="font-size: 24px; color: #10B981;"></i>
                <div>
                    <h3>AI Promosi</h3>
                    <p class="text-sm text-gray">Buat konten promosi otomatis</p>
                </div>
            </a>
        </div>
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
    <a href="{{ route('umkm.dashboard') }}" class="active">
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
    <a href="{{ route('profile.show') }}">
        <i class="fas fa-user"></i>
        <span>Profil</span>
    </a>
</nav>
@endsection
