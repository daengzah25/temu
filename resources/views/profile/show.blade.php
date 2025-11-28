@extends('layouts.app')

@section('title', 'Profil - Temu')

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="bg-surface border border-border p-6 rounded-lg2 text-center">
        <div class="inline-flex items-center justify-center mb-4">
            <img 
                src="{{ $user->avatar }}" 
                alt="Avatar" 
                class="w-24 h-24 rounded-full border-4 border-accent object-cover"
            >
        </div>
        <h2 class="text-xl font-bold mb-2 text-text">{{ $user->name }}</h2>
        <p class="text-sm text-muted mb-3">{{ $user->email }}</p>
        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-semibold
            {{ $user->role === 'admin' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/50' : 
               ($user->role === 'umkm' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/50' : 
                'bg-green-500/20 text-green-400 border border-green-500/50') }}">
            {{ strtoupper($user->role) }}
        </span>
    </div>

    @if($user->role === 'umkm' && $user->company)
        <div class="bg-surface border border-border p-6 rounded-lg2">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2 text-text">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                UMKM Saya
            </h3>
            <div class="flex items-center gap-3 mb-4">
                @if($user->company->logo)
                    <img 
                        src="{{ $user->company->logo }}" 
                        alt="Logo" 
                        class="w-16 h-16 rounded-lg object-cover flex-shrink-0"
                    >
                @else
                    <div class="w-16 h-16 rounded-lg bg-surface/80 flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-muted/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-base mb-1 truncate text-text">{{ $user->company->name }}</h3>
                    <p class="text-sm text-muted">
                        <span class="inline-block px-2 py-0.5 bg-surface/80 rounded text-xs">{{ $user->company->category }}</span>
                    </p>
                </div>
            </div>
            <div class="flex gap-2">
                <a 
                    href="{{ route('umkm.dashboard') }}" 
                    class="flex-1 px-4 py-2.5 rounded-lg bg-accent text-accent-contrast font-medium hover:opacity-90 transition text-center flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                <a 
                    href="{{ route('umkm.profile.edit') }}" 
                    class="flex-1 px-4 py-2.5 rounded-lg bg-green-500 hover:bg-green-600 text-white font-medium transition text-center flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Profil
                </a>
            </div>
        </div>
    @endif

    <!-- Settings -->
    <div class="bg-surface border border-border p-6 rounded-lg2">
        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2 text-text">
            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Pengaturan
        </h3>
        <div class="space-y-3">
            @if($user->role === 'admin')
                <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="bg-surface/80 border border-border p-4 rounded-lg hover:bg-surface transition flex items-center gap-3"
                >
                    <div class="flex-shrink-0 w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-base text-text">Dashboard Admin</h3>
                        <p class="text-sm text-muted">Kelola UMKM & user</p>
                    </div>
                    <svg class="w-5 h-5 text-muted/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @endif

            @if($user->role === 'umkm')
                <a 
                    href="{{ route('products.index') }}" 
                    class="bg-surface/80 border border-border p-4 rounded-lg hover:bg-surface transition flex items-center gap-3"
                >
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-base text-text">Produk Saya</h3>
                        <p class="text-sm text-muted">{{ $user->company ? $user->company->products->count() : 0 }} produk</p>
                    </div>
                    <svg class="w-5 h-5 text-muted/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a 
                    href="{{ route('ai-promotion.index') }}" 
                    class="bg-surface/80 border border-border p-4 rounded-lg hover:bg-surface transition flex items-center gap-3"
                >
                    <div class="flex-shrink-0 w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-base text-text">AI Promosi</h3>
                        <p class="text-sm text-muted">Generate konten otomatis</p>
                    </div>
                    <svg class="w-5 h-5 text-muted/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @endif

            @if($user->role === 'visitor')
                <a 
                    href="{{ route('bookmarks.index') }}" 
                    class="bg-surface/80 border border-border p-4 rounded-lg hover:bg-surface transition flex items-center gap-3"
                >
                    <div class="flex-shrink-0 w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-base text-text">Favorit Saya</h3>
                        <p class="text-sm text-muted">{{ $user->bookmarks->count() }} UMKM tersimpan</p>
                    </div>
                    <svg class="w-5 h-5 text-muted/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a 
                    href="{{ route('visitor.nearby') }}" 
                    class="bg-surface/80 border border-border p-4 rounded-lg hover:bg-surface transition flex items-center gap-3"
                >
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-base text-text">Cari UMKM</h3>
                        <p class="text-sm text-muted">Temukan UMKM terdekat</p>
                    </div>
                    <svg class="w-5 h-5 text-muted/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @endif
        </div>
    </div>

    <!-- Account Info -->
    <div class="bg-surface border border-border p-6 rounded-lg2">
        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2 text-text">
            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Tentang Akun
        </h3>
        <div class="space-y-3 text-sm">
            <div class="flex items-center gap-3 text-muted">
                <svg class="w-5 h-5 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Bergabung: <span class="text-text">{{ $user->created_at->format('d M Y') }}</span></span>
            </div>
            <div class="flex items-center gap-3 text-muted">
                <svg class="w-5 h-5 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Terakhir login: <span class="text-text">{{ $user->updated_at->diffForHumans() }}</span></span>
            </div>
        </div>
    </div>

    <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button 
            type="submit" 
            class="w-full px-4 py-3 rounded-lg bg-red-500/20 border border-red-500/50 text-red-400 hover:bg-red-500/30 transition flex items-center justify-center gap-2 font-medium"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            Keluar
        </button>
    </form>
</div>
@endsection
