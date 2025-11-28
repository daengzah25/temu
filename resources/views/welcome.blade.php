@extends('layouts.app')

@section('title', 'Temu - Temukan UMKM Terdekat')

@section('content')
<div class="space-y-6">
    <!-- Hero Section -->
    <div class="text-center py-8">
        <div class="inline-flex items-center justify-center mb-4">
            <img src="/images/2.png" alt="Logo Temu UMKM" class="h-24 w-24 object-contain" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2240%22 fill=%22%23fff%22/%3E%3Ctext x=%2250%22 y=%2265%22 font-size=%2240%22 text-anchor=%22middle%22 fill=%22%23000%22%3ET%3C/text%3E%3C/svg%3E'">
        </div>
        <h1 class="text-3xl font-bold mb-2">Temu</h1>
        <p class="text-white/70 mb-6 text-lg">
            Temukan UMKM Lokal di Sekitar Anda
        </p>

        @guest
            <a href="{{ route('auth.google') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-brand-accent text-black font-semibold hover:bg-brand-accent/90 transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Masuk dengan Google
            </a>
        @else
            @if(Auth::user()->role === 'visitor')
                <a href="{{ route('visitor.home') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-brand-accent text-black font-semibold hover:bg-brand-accent/90 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari UMKM Terdekat
                </a>
            @elseif(Auth::user()->role === 'umkm')
                <a href="{{ route('umkm.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-brand-accent text-black font-semibold hover:bg-brand-accent/90 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Dashboard UMKM Saya
                </a>
            @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-brand-accent text-black font-semibold hover:bg-brand-accent/90 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                    Dashboard Admin
                </a>
            @endif
        @endguest
    </div>

    <!-- Features -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <h2 class="text-xl font-semibold mb-4 text-center flex items-center justify-center gap-2">
            <span class="text-brand-accent"></span>
            Fitur Unggulan
        </h2>

        <div class="space-y-3">
            <div class="bg-white/5 border border-white/10 p-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Pencarian Lokasi Real-Time</h3>
                        <p class="text-sm text-white/70">Temukan UMKM terdekat dengan GPS otomatis berdasarkan lokasi Anda saat ini</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 p-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">AI Promosi Otomatis</h3>
                        <p class="text-sm text-white/70">Generate konten promosi untuk Instagram, WhatsApp, dan Facebook dengan teknologi AI</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 p-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Simpan Favorit</h3>
                        <p class="text-sm text-white/70">Bookmark UMKM favorit Anda untuk akses cepat kapan saja</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 p-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-brand-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Kontak Langsung</h3>
                        <p class="text-sm text-white/70">Hubungi pemilik UMKM langsung melalui WhatsApp dengan satu klik</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <h2 class="text-xl font-semibold mb-4 text-center flex items-center justify-center gap-2">
            <span class="text-brand-accent"></span>
            Cara Menggunakan
        </h2>

        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-brand-accent text-black rounded-full flex items-center justify-center font-bold text-lg">1</div>
                <div>
                    <h3 class="font-semibold mb-1">Login dengan Google</h3>
                    <p class="text-sm text-white/70">Masuk menggunakan akun Google Anda, aman dan cepat</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-brand-accent text-black rounded-full flex items-center justify-center font-bold text-lg">2</div>
                <div>
                    <h3 class="font-semibold mb-1">Pilih Peran Anda</h3>
                    <p class="text-sm text-white/70">Sebagai Pengunjung untuk cari UMKM atau sebagai Pemilik UMKM untuk promosi</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-brand-accent text-black rounded-full flex items-center justify-center font-bold text-lg">3</div>
                <div>
                    <h3 class="font-semibold mb-1">Mulai Jelajahi</h3>
                    <p class="text-sm text-white/70">Temukan UMKM terdekat atau kelola bisnis Anda dengan mudah</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl text-center">
        <h2 class="text-xl font-semibold mb-4 flex items-center justify-center gap-2">
            <span class="text-brand-accent"></span>
            Temu dalam Angka
        </h2>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <h2 class="text-brand-accent text-3xl font-bold mb-1">{{ \App\Models\Company::where('status', 'approved')->count() }}+</h2>
                <p class="text-sm text-white/70">UMKM Terdaftar</p>
            </div>
            <div>
                <h2 class="text-brand-accent text-3xl font-bold mb-1">{{ \App\Models\User::where('role', 'visitor')->count() }}+</h2>
                <p class="text-sm text-white/70">Pengguna Aktif</p>
            </div>
            <div>
                <h2 class="text-brand-accent text-3xl font-bold mb-1">{{ \App\Models\Product::count() }}+</h2>
                <p class="text-sm text-white/70">Produk UMKM</p>
            </div>
        </div>
    </div>

    <!-- Team -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <h2 class="text-xl font-semibold mb-4 text-center flex items-center justify-center gap-2">
            <span class="text-brand-accent"></span>
            Tim Pengembang
        </h2>

        <div class="space-y-3">
            <div class="bg-gradient-to-r from-purple-500/20 to-purple-600/20 border border-purple-500/30 p-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold">Daeng</h3>
                        <p class="text-sm text-white/70">Project Manager, Fullstack Developer</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-pink-500/20 to-red-500/20 border border-pink-500/30 p-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold">Dafong</h3>
                        <p class="text-sm text-white/70">Frontend Developer</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-blue-500/20 to-cyan-500/20 border border-blue-500/30 p-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold">Adhwaa</h3>
                        <p class="text-sm text-white/70">Backend Developer</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500/20 to-teal-500/20 border border-green-500/30 p-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold">Safutra</h3>
                        <p class="text-sm text-white/70">Fullstack Developer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl text-center">
        <p class="text-sm text-white/70">
            © 2025 Temu. Platform UMKM Indonesia.<br>
            Dibuat dengan ❤️ untuk mendukung UMKM lokal
        </p>
    </div>
</div>
@endsection
