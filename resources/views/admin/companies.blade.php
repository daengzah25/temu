@extends('layouts.app')

@section('title', 'Kelola UMKM - Admin')

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
            <div class="w-12 h-12 rounded-lg bg-blue-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold">Kelola UMKM</h2>
                <p class="text-sm text-white/60">Total: {{ $companies->total() }} UMKM</p>
            </div>
        </div>
    </div>

    <!-- Filter Status -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <div class="grid grid-cols-4 gap-2">
            <a href="{{ route('admin.companies', ['status' => 'all']) }}" class="py-2 px-3 rounded-lg text-center text-sm font-medium transition {{ $status === 'all' ? 'bg-blue-500/20 border border-blue-500/30 text-blue-400' : 'bg-white/5 border border-white/10 text-white/60 hover:bg-white/10' }}">
                Semua
            </a>
            <a href="{{ route('admin.companies', ['status' => 'pending']) }}" class="py-2 px-3 rounded-lg text-center text-sm font-medium transition {{ $status === 'pending' ? 'bg-yellow-500/20 border border-yellow-500/30 text-yellow-400' : 'bg-white/5 border border-white/10 text-white/60 hover:bg-white/10' }}">
                Pending
            </a>
            <a href="{{ route('admin.companies', ['status' => 'approved']) }}" class="py-2 px-3 rounded-lg text-center text-sm font-medium transition {{ $status === 'approved' ? 'bg-green-500/20 border border-green-500/30 text-green-400' : 'bg-white/5 border border-white/10 text-white/60 hover:bg-white/10' }}">
                Approved
            </a>
            <a href="{{ route('admin.companies', ['status' => 'rejected']) }}" class="py-2 px-3 rounded-lg text-center text-sm font-medium transition {{ $status === 'rejected' ? 'bg-red-500/20 border border-red-500/30 text-red-400' : 'bg-white/5 border border-white/10 text-white/60 hover:bg-white/10' }}">
                Rejected
            </a>
        </div>
    </div>

    <!-- List UMKM -->
    @forelse($companies as $company)
        <div class="bg-white/6 border border-white/10 rounded-xl overflow-hidden {{ $company->status === 'pending' ? 'border-l-4 border-l-yellow-500' : ($company->status === 'approved' ? 'border-l-4 border-l-green-500' : 'border-l-4 border-l-red-500') }}">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
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
                        <p class="text-sm text-white/60">{{ $company->category }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $company->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : ($company->status === 'approved' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400') }}">
                        {{ strtoupper($company->status) }}
                    </span>
                </div>

                <div class="space-y-2 mb-4 text-sm text-white/60">
                    <p class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $company->user->name }}
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ Str::limit($company->address, 50) }}
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Daftar: {{ $company->created_at->format('d M Y, H:i') }}
                    </p>
                </div>

                <a href="{{ route('admin.company.show', $company->id) }}" class="block w-full bg-blue-500/10 border border-blue-500/20 hover:bg-blue-500/15 transition text-blue-400 text-center py-2 px-4 rounded-lg text-sm font-medium">
                    Review Detail
                </a>
            </div>
        </div>
    @empty
        <div class="bg-white/6 border border-white/10 p-12 rounded-xl text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h3 class="font-semibold mb-2">Tidak Ada UMKM</h3>
            <p class="text-white/60">Belum ada UMKM dengan status {{ $status }}</p>
        </div>
    @endforelse

    <!-- Pagination -->
    @if($companies->hasPages())
        <div class="bg-white/6 border border-white/10 p-4 rounded-xl">
            <div class="flex justify-between items-center">
                @if($companies->onFirstPage())
                    <span class="text-white/40">← Prev</span>
                @else
                    <a href="{{ $companies->previousPageUrl() }}" class="text-blue-400 hover:text-blue-300 transition">← Prev</a>
                @endif

                <span class="text-sm text-white/60">
                    Page {{ $companies->currentPage() }} of {{ $companies->lastPage() }}
                </span>

                @if($companies->hasMorePages())
                    <a href="{{ $companies->nextPageUrl() }}" class="text-blue-400 hover:text-blue-300 transition">Next →</a>
                @else
                    <span class="text-white/40">Next →</span>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection

@section('bottom-nav')
<nav class="fixed bottom-4 left-4 right-4 bg-white/6 border border-white/10 rounded-xl shadow-lg flex justify-around items-center py-3 px-2 z-50 backdrop-blur-sm">
    <a 
        href="{{ route('admin.dashboard') }}" 
        class="flex flex-col items-center px-3 py-2 text-white/60 hover:text-white transition rounded-lg hover:bg-white/5 {{ request()->routeIs('admin.dashboard') ? 'text-brand-accent bg-white/5' : '' }}"
    >
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
        </svg>
        <span class="text-xs">Admin</span>
    </a>
    <a 
        href="{{ route('admin.companies') }}" 
        class="flex flex-col items-center px-3 py-2 text-brand-accent transition rounded-lg bg-white/5"
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
