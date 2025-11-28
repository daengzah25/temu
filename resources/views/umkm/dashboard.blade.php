@extends('layouts.app')

@section('title', 'Dashboard UMKM - Temu')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-500/20 border border-green-500/30">
            <p class="text-green-100">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Company Info -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <div class="flex items-center gap-4">
            @if($company->logo)
                <img src="{{ $company->logo }}" alt="Logo" class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
            @else
                <div class="w-16 h-16 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-8 h-8 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            @endif
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold truncate">{{ $company->name }}</h2>
                <p class="text-sm text-white/60 mb-2">{{ $company->category }}</p>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-500/20 text-green-400 text-xs font-semibold">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    APPROVED
                </span>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <h3 class="font-semibold mb-4">Statistik Ringkas</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-blue-500/10 border border-blue-500/20 p-4 rounded-lg text-center">
                <p class="text-sm text-white/60 mb-1">Total Produk</p>
                <h2 class="text-2xl font-bold text-blue-400">{{ $company->products->count() }}</h2>
            </div>
            <div class="bg-green-500/10 border border-green-500/20 p-4 rounded-lg text-center">
                <p class="text-sm text-white/60 mb-1">Promosi AI</p>
                <h2 class="text-2xl font-bold text-green-400">0</h2>
            </div>
        </div>
    </div>

    <!-- Quick Menu -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <h3 class="font-semibold mb-4">Menu Cepat</h3>
        <div class="space-y-3">
            <a href="{{ route('products.index') }}" class="bg-blue-500/10 border border-blue-500/20 p-4 rounded-lg hover:bg-blue-500/15 transition flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-lg bg-blue-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-500/30 transition">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold mb-1">Kelola Produk</h3>
                    <p class="text-sm text-white/60">Tambah, edit, atau hapus produk</p>
                </div>
                <svg class="w-5 h-5 text-white/40 group-hover:text-white/60 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="{{ route('ai-promotion.index') }}" class="bg-green-500/10 border border-green-500/20 p-4 rounded-lg hover:bg-green-500/15 transition flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-green-500/30 transition">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold mb-1">AI Promosi</h3>
                    <p class="text-sm text-white/60">Buat konten promosi otomatis</p>
                </div>
                <svg class="w-5 h-5 text-white/40 group-hover:text-white/60 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection

@section('bottom-nav')
<nav class="fixed bottom-4 left-4 right-4 bg-white/6 border border-white/10 rounded-xl shadow-lg flex justify-around items-center py-3 px-2 z-50 backdrop-blur-sm">
    <a 
        href="{{ route('umkm.dashboard') }}" 
        class="flex flex-col items-center px-3 py-2 text-brand-accent transition rounded-lg bg-white/5"
    >
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        <span class="text-xs">Home</span>
    </a>
    <a 
        href="{{ route('products.index') }}" 
        class="flex flex-col items-center px-3 py-2 text-white/60 hover:text-white transition rounded-lg hover:bg-white/5 {{ request()->routeIs('products.*') ? 'text-brand-accent bg-white/5' : '' }}"
    >
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
        </svg>
        <span class="text-xs">Produk</span>
    </a>
    <a 
        href="{{ route('ai-promotion.index') }}" 
        class="flex flex-col items-center px-3 py-2 text-white/60 hover:text-white transition rounded-lg hover:bg-white/5 {{ request()->routeIs('ai-promotion.*') ? 'text-brand-accent bg-white/5' : '' }}"
    >
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
        </svg>
        <span class="text-xs">AI Promosi</span>
    </a>
    <a 
        href="{{ route('profile.show') }}" 
        class="flex flex-col items-center px-3 py-2 text-white/60 hover:text-white transition rounded-lg hover:bg-white/5 {{ request()->routeIs('profile.*') ? 'text-brand-accent bg-white/5' : '' }}"
    >
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        <span class="text-xs">Profil</span>
    </a>
</nav>
@endsection
