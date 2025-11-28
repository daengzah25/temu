@extends('layouts.app')

@section('title', 'Admin Dashboard - Temu')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-500/20 border border-green-500/30">
            <p class="text-green-100">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-lg bg-yellow-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold">Dashboard Admin</h2>
                <p class="text-sm text-white/60">Kelola pendaftaran UMKM dan user</p>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <h3 class="font-semibold mb-4">Ringkasan</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-yellow-500/10 border border-yellow-500/20 p-4 rounded-lg text-center">
                <p class="text-sm text-white/60 mb-1">Menunggu Approval</p>
                <h2 class="text-2xl font-bold text-yellow-400">{{ $stats['pending'] }}</h2>
            </div>
            <div class="bg-green-500/10 border border-green-500/20 p-4 rounded-lg text-center">
                <p class="text-sm text-white/60 mb-1">UMKM Aktif</p>
                <h2 class="text-2xl font-bold text-green-400">{{ $stats['approved'] }}</h2>
            </div>
            <div class="bg-red-500/10 border border-red-500/20 p-4 rounded-lg text-center">
                <p class="text-sm text-white/60 mb-1">Ditolak Hari Ini</p>
                <h2 class="text-2xl font-bold text-red-400">{{ $stats['rejected'] }}</h2>
            </div>
            <div class="bg-blue-500/10 border border-blue-500/20 p-4 rounded-lg text-center">
                <p class="text-sm text-white/60 mb-1">Total User</p>
                <h2 class="text-2xl font-bold text-blue-400">{{ $stats['total_users'] }}</h2>
            </div>
        </div>
    </div>

    <!-- Pending Companies -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold">UMKM Menunggu Approval ({{ $pendingCompanies->count() }})</h3>
            <a href="{{ route('admin.companies', ['status' => 'pending']) }}" class="text-sm text-blue-400 hover:text-blue-300 transition">
                Lihat Semua →
            </a>
        </div>

        @forelse($pendingCompanies as $company)
            <div class="bg-yellow-500/10 border border-yellow-500/20 p-4 rounded-lg mb-3 last:mb-0">
                <div class="flex items-center gap-4 mb-3">
                    @if($company->logo)
                        <img src="{{ $company->logo }}" alt="Logo" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                    @else
                        <div class="w-12 h-12 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold truncate">{{ $company->name }}</h3>
                        <p class="text-sm text-white/60 mb-1">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ Str::limit($company->address, 40) }}
                        </p>
                        <p class="text-sm text-white/60">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Daftar: {{ $company->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('admin.company.show', $company->id) }}" class="block w-full bg-blue-500/10 border border-blue-500/20 hover:bg-blue-500/15 transition text-blue-400 text-center py-2 px-4 rounded-lg text-sm font-medium">
                    Review
                </a>
            </div>
        @empty
            <p class="text-center text-white/60 py-8">Tidak ada UMKM yang menunggu approval</p>
        @endforelse
    </div>

    <!-- Logout -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="w-full bg-white/10 border border-white/20 hover:bg-white/15 transition text-white py-3 px-4 rounded-lg font-medium">
            Keluar
        </button>
    </form>
</div>
@endsection

@section('bottom-nav')
<nav class="fixed bottom-4 left-4 right-4 bg-white/6 border border-white/10 rounded-xl shadow-lg flex justify-around items-center py-3 px-2 z-50 backdrop-blur-sm">
    <a 
        href="{{ route('admin.dashboard') }}" 
        class="flex flex-col items-center px-3 py-2 text-brand-accent transition rounded-lg bg-white/5"
    >
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
        </svg>
        <span class="text-xs">Admin</span>
    </a>
    <a 
        href="{{ route('admin.companies', ['status' => 'pending']) }}" 
        class="flex flex-col items-center px-3 py-2 text-white/60 hover:text-white transition rounded-lg hover:bg-white/5 {{ request()->routeIs('admin.companies*') ? 'text-brand-accent bg-white/5' : '' }}"
    >
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        <span class="text-xs">UMKM</span>
    </a>
    <a 
        href="{{ route('admin.users.index') }}" 
        class="flex flex-col items-center px-3 py-2 text-white/60 hover:text-white transition rounded-lg hover:bg-white/5 {{ request()->routeIs('admin.users*') ? 'text-brand-accent bg-white/5' : '' }}"
    >
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <span class="text-xs">User</span>
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
