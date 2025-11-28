@extends('layouts.app')

@section('title', 'Review UMKM - Admin')

@section('content')
<div class="space-y-6">
    @if (session('success'))
        <div class="p-4 rounded-lg bg-green-500/20 border border-green-500/30">
            <p class="text-green-100">{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 rounded-lg bg-red-500/20 border border-red-500/30">
            @foreach ($errors->all() as $error)
                <p class="text-red-100 text-sm">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 transition text-sm mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
        <h2 class="text-xl font-bold">Review Pendaftaran UMKM</h2>
    </div>

    <!-- Company Info -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        @if ($company->logo)
            <img src="{{ $company->logo }}" alt="Logo" class="w-full max-w-[200px] h-[200px] object-cover rounded-xl mx-auto mb-6">
        @endif

        <h3 class="font-semibold mb-4">Informasi UMKM</h3>
        <div class="space-y-3 text-sm">
            <div>
                <p class="text-white/60 mb-1">Nama Usaha</p>
                <p class="font-medium">{{ $company->name }}</p>
            </div>
            <div>
                <p class="text-white/60 mb-1">Kategori</p>
                <p class="font-medium">{{ $company->category }}</p>
            </div>
            <div>
                <p class="text-white/60 mb-1">Deskripsi</p>
                <p class="font-medium">{{ $company->description ?? '-' }}</p>
            </div>
            <div>
                <p class="text-white/60 mb-1">Alamat</p>
                <p class="font-medium">{{ $company->address }}</p>
            </div>
            <div>
                <p class="text-white/60 mb-1">Koordinat</p>
                <p class="font-medium">{{ $company->latitude }}, {{ $company->longitude }}</p>
            </div>
            <div>
                <p class="text-white/60 mb-1">WhatsApp</p>
                <p class="font-medium">{{ $company->whatsapp }}</p>
            </div>
            <div>
                <p class="text-white/60 mb-1">Jam Operasional</p>
                <p class="font-medium">{{ $company->operating_hours ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Owner Info -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <h3 class="font-semibold mb-4">Pemilik</h3>
        <div class="flex items-center gap-4">
            <img src="{{ $company->user->avatar }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover">
            <div>
                <p class="font-semibold">{{ $company->user->name }}</p>
                <p class="text-sm text-white/60">{{ $company->user->email }}</p>
                <p class="text-sm text-white/60">Daftar: {{ $company->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>

    @if ($company->status === 'pending')
        <!-- Approve Form -->
        <div class="bg-green-500/10 border border-green-500/20 p-6 rounded-xl">
            <h3 class="font-semibold mb-4 text-green-400">Setujui Pendaftaran</h3>
            <form action="{{ route('admin.company.approve', $company->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-green-500/20 border border-green-500/30 hover:bg-green-500/30 transition text-green-400 py-3 px-4 rounded-lg font-medium">
                    Setujui UMKM Ini
                </button>
            </form>
        </div>

        <!-- Reject Form -->
        <div class="bg-red-500/10 border border-red-500/20 p-6 rounded-xl">
            <h3 class="font-semibold mb-4 text-red-400">Tolak Pendaftaran</h3>
            <form action="{{ route('admin.company.reject', $company->id) }}" method="POST">
                @csrf
                <label class="block text-sm font-medium mb-2">Alasan Penolakan (Wajib) *</label>
                <textarea name="reason" rows="3" required class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500/50 mb-4" placeholder="Contoh: Alamat tidak lengkap. Mohon sertakan nama jalan, nomor, dan kode pos."></textarea>
                <button type="submit" class="w-full bg-red-500/20 border border-red-500/30 hover:bg-red-500/30 transition text-red-400 py-3 px-4 rounded-lg font-medium">
                    Tolak Pendaftaran
                </button>
            </form>
        </div>
    @else
        <!-- Status Display -->
        <div class="bg-white/6 border border-white/10 p-6 rounded-xl text-center">
            <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold {{ $company->status === 'approved' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                Status: {{ strtoupper($company->status) }}
            </span>
            @if ($company->rejection_reason)
                <p class="text-sm text-white/60 mt-4">Alasan: {{ $company->rejection_reason }}</p>
            @endif
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
