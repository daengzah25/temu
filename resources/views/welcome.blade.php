@extends('layouts.app')

@section('title', 'Temu - Temukan UMKM Terdekat')

@section('content')
<div class="container">
    @if(session('error'))
        <div class="card" style="background: #FEE2E2; border-left: 4px solid #EF4444;">
            <p style="color: #991B1B;">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Hero Section -->
    <div class="card text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px 20px;">
        <i class="fas fa-store" style="font-size: 80px; margin-bottom: 20px; opacity: 0.9;"></i>
        <h1 style="font-size: 32px; margin-bottom: 12px; color: white;">Temu</h1>
        <p style="font-size: 18px; margin-bottom: 24px; color: rgba(255,255,255,0.9);">
            Temukan UMKM Lokal di Sekitar Anda
        </p>

        @guest
            <a href="{{ route('auth.google') }}" class="btn btn-block" style="background: white; color: #667eea; font-weight: 600; max-width: 300px; margin: 0 auto;">
                <i class="fab fa-google"></i> Masuk dengan Google
            </a>
        @else
            @if(Auth::user()->role === 'visitor')
                <a href="{{ route('visitor.home') }}" class="btn btn-block" style="background: white; color: #667eea; font-weight: 600; max-width: 300px; margin: 0 auto;">
                    <i class="fas fa-search"></i> Cari UMKM Terdekat
                </a>
            @elseif(Auth::user()->role === 'umkm')
                <a href="{{ route('umkm.dashboard') }}" class="btn btn-block" style="background: white; color: #667eea; font-weight: 600; max-width: 300px; margin: 0 auto;">
                    <i class="fas fa-store"></i> Dashboard UMKM Saya
                </a>
            @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-block" style="background: white; color: #667eea; font-weight: 600; max-width: 300px; margin: 0 auto;">
                    <i class="fas fa-crown"></i> Dashboard Admin
                </a>
            @endif
        @endguest
    </div>

    <!-- Features -->
    <div class="card">
        <h2 class="text-center mb3">🚀 Fitur Unggulan</h2>

        <div class="card" style="background: #F0F9FF; margin-bottom: 12px;">
            <div class="flex items-center gap">
                <div style="min-width: 50px; text-align: center;">
                    <i class="fas fa-map-marker-alt" style="font-size: 32px; color: #3B82F6;"></i>
                </div>
                <div>
                    <h3>Pencarian Lokasi Real-Time</h3>
                    <p class="text-sm text-gray">Temukan UMKM terdekat dengan GPS otomatis berdasarkan lokasi Anda saat ini</p>
                </div>
            </div>
        </div>

        <div class="card" style="background: #F0FDF4; margin-bottom: 12px;">
            <div class="flex items-center gap">
                <div style="min-width: 50px; text-align: center;">
                    <i class="fas fa-robot" style="font-size: 32px; color: #10B981;"></i>
                </div>
                <div>
                    <h3>AI Promosi Otomatis</h3>
                    <p class="text-sm text-gray">Generate konten promosi untuk Instagram, WhatsApp, dan Facebook dengan teknologi AI</p>
                </div>
            </div>
        </div>

        <div class="card" style="background: #FEF3C7; margin-bottom: 12px;">
            <div class="flex items-center gap">
                <div style="min-width: 50px; text-align: center;">
                    <i class="fas fa-heart" style="font-size: 32px; color: #EF4444;"></i>
                </div>
                <div>
                    <h3>Simpan Favorit</h3>
                    <p class="text-sm text-gray">Bookmark UMKM favorit Anda untuk akses cepat kapan saja</p>
                </div>
            </div>
        </div>

        <div class="card" style="background: #FEE2E2;">
            <div class="flex items-center gap">
                <div style="min-width: 50px; text-align: center;">
                    <i class="fab fa-whatsapp" style="font-size: 32px; color: #10B981;"></i>
                </div>
                <div>
                    <h3>Kontak Langsung</h3>
                    <p class="text-sm text-gray">Hubungi pemilik UMKM langsung melalui WhatsApp dengan satu klik</p>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="card">
        <h2 class="text-center mb3">📱 Cara Menggunakan</h2>

        <div style="display: grid; gap: 16px;">
            <div class="flex items-center gap">
                <div style="min-width: 40px; height: 40px; background: #667eea; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 20px;">1</div>
                <div>
                    <h3>Login dengan Google</h3>
                    <p class="text-sm text-gray">Masuk menggunakan akun Google Anda, aman dan cepat</p>
                </div>
            </div>

            <div class="flex items-center gap">
                <div style="min-width: 40px; height: 40px; background: #667eea; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 20px;">2</div>
                <div>
                    <h3>Pilih Peran Anda</h3>
                    <p class="text-sm text-gray">Sebagai Pengunjung untuk cari UMKM atau sebagai Pemilik UMKM untuk promosi</p>
                </div>
            </div>

            <div class="flex items-center gap">
                <div style="min-width: 40px; height: 40px; background: #667eea; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 20px;">3</div>
                <div>
                    <h3>Mulai Jelajahi</h3>
                    <p class="text-sm text-gray">Temukan UMKM terdekat atau kelola bisnis Anda dengan mudah</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="card text-center" style="background: #F9FAFB;">
        <h2 class="mb3">📊 Temu dalam Angka</h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
            <div>
                <h2 style="color: #667eea; font-size: 36px; margin-bottom: 4px;">{{ \App\Models\Company::where('status', 'approved')->count() }}+</h2>
                <p class="text-sm text-gray">UMKM Terdaftar</p>
            </div>
            <div>
                <h2 style="color: #10B981; font-size: 36px; margin-bottom: 4px;">{{ \App\Models\User::where('role', 'visitor')->count() }}+</h2>
                <p class="text-sm text-gray">Pengguna Aktif</p>
            </div>
            <div>
                <h2 style="color: #EF4444; font-size: 36px; margin-bottom: 4px;">{{ \App\Models\Product::count() }}+</h2>
                <p class="text-sm text-gray">Produk UMKM</p>
            </div>
        </div>
    </div>

    <!-- Team -->
    <div class="card">
        <h2 class="text-center mb3">👥 Tim Pengembang</h2>

        <div style="display: grid; gap: 12px;">
            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="flex items-center gap">
                    <div style="min-width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-tie" style="font-size: 24px;"></i>
                    </div>
                    <div>
                        <h3 style="color: white;">Daeng</h3>
                        <p style="font-size: 14px; color: rgba(255,255,255,0.8);">Project Manager, Fullstack Developer</p>
                    </div>
                </div>
            </div>

            <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <div class="flex items-center gap">
                    <div style="min-width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-paint-brush" style="font-size: 24px;"></i>
                    </div>
                    <div>
                        <h3 style="color: white;">Dafong</h3>
                        <p style="font-size: 14px; color: rgba(255,255,255,0.8);">Frontend Developer</p>
                    </div>
                </div>
            </div>

            <div class="card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                <div class="flex items-center gap">
                    <div style="min-width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-database" style="font-size: 24px;"></i>
                    </div>
                    <div>
                        <h3 style="color: white;">Adhwaa</h3>
                        <p style="font-size: 14px; color: rgba(255,255,255,0.8);">Backend Developer</p>
                    </div>
                </div>
            </div>

            <div class="card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                <div class="flex items-center gap">
                    <div style="min-width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-code" style="font-size: 24px;"></i>
                    </div>
                    <div>
                        <h3 style="color: white;">Safutra</h3>
                        <p style="font-size: 14px; color: rgba(255,255,255,0.8);">Fullstack Developer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="card text-center" style="background: #F9FAFB;">
        <p class="text-sm text-gray">
            © 2025 Temu. Platform UMKM Indonesia.<br>
            Dibuat dengan ❤️ untuk mendukung UMKM lokal
        </p>
    </div>
</div>
@endsection

@section('bottom-nav')
@auth
    @if(Auth::user()->role === 'visitor')
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
            <a href="{{ route('profile.show') }}">
                <i class="fas fa-user"></i>
                <span>Profil</span>
            </a>
        </nav>
    @endif
@endauth
@endsection
