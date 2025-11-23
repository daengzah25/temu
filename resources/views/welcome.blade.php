@extends('layouts.app')

@section('title', 'Welcome - Temu')

@section('content')
<div class="container">
    @if(session('error'))
        <div class="card" style="background: #FEE2E2; border-left: 4px solid #EF4444;">
            <p style="color: #991B1B;">{{ session('error') }}</p>
        </div>
    @endif

    <div class="card text-center">
        <i class="fas fa-store text-blue" style="font-size: 64px; margin-bottom: 16px;"></i>
        <h1>Selamat Datang di Temu</h1>
        <p class="text-gray mb2">Platform untuk menemukan UMKM terdekat</p>

        @guest
            <a href="{{ route('auth.google') }}" class="btn btn-primary btn-block">
                <i class="fab fa-google"></i> Masuk dengan Google
            </a>
        @else
            @if(Auth::user()->role === 'visitor')
                <a href="{{ route('visitor.home') }}" class="btn btn-primary btn-block">
                    <i class="fas fa-search"></i> Cari UMKM Terdekat
                </a>
            @elseif(Auth::user()->role === 'umkm')
                <a href="{{ route('umkm.dashboard') }}" class="btn btn-primary btn-block">
                    <i class="fas fa-store"></i> Dashboard UMKM
                </a>
            @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-block">
                    <i class="fas fa-crown"></i> Dashboard Admin
                </a>
            @endif
        @endguest
    </div>

    <div class="card">
        <h3><i class="fas fa-check-circle text-blue"></i> Fitur Temu</h3>
        <div class="text-sm text-gray">
            <p class="mb">✅ Laravel {{ app()->version() }}</p>
            <p class="mb">✅ Login dengan Google</p>
            <p class="mb">✅ Cari UMKM terdekat</p>
            <p>✅ Kelola produk & AI Promosi</p>
        </div>
    </div>
</div>
@endsection

@section('bottom-nav')
@auth
    @if(Auth::user()->role === 'visitor')
        <nav class="bottom-nav">
            <a href="{{ route('visitor.home') }}" class="active">
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
            <a href="#">
                <i class="fas fa-user"></i>
                <span>Profil</span>
            </a>
        </nav>
    @endif
@endauth
@endsection
