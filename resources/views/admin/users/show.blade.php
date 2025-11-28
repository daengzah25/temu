@extends('layouts.app')

@section('title', 'Detail User - Admin')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-500/20 border border-green-500/30">
            <p class="text-green-100">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 transition text-sm mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
        <h2 class="text-xl font-bold">Detail User</h2>
    </div>

    <!-- User Profile -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl text-center">
        <img src="{{ $user->avatar }}" alt="Avatar" class="w-24 h-24 rounded-full mx-auto mb-4 border-4 {{ $user->status === 'active' ? 'border-green-500/50' : 'border-red-500/50' }}">
        <h2 class="text-xl font-bold mb-2">{{ $user->name }}</h2>
        <p class="text-sm text-white/60 mb-4">{{ $user->email }}</p>
        <div class="flex gap-2 justify-center">
            <span class="px-4 py-1 rounded-full text-xs font-semibold {{ $user->role === 'admin' ? 'bg-yellow-500/20 text-yellow-400' : ($user->role === 'umkm' ? 'bg-blue-500/20 text-blue-400' : 'bg-green-500/20 text-green-400') }}">
                {{ strtoupper($user->role) }}
            </span>
            <span class="px-4 py-1 rounded-full text-xs font-semibold {{ $user->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                {{ $user->status === 'active' ? 'AKTIF' : 'BANNED' }}
            </span>
        </div>
    </div>

    @if($user->role === 'umkm' && $user->company)
        <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
            <h3 class="font-semibold mb-4">Info UMKM</h3>
            <div class="flex items-center gap-4 mb-4">
                @if($user->company->logo)
                    <img src="{{ $user->company->logo }}" alt="Logo" class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                @endif
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold truncate">{{ $user->company->name }}</h3>
                    <p class="text-sm text-white/60">{{ $user->company->category }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->company->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : ($user->company->status === 'approved' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400') }}">
                    {{ strtoupper($user->company->status) }}
                </span>
            </div>
            <div class="space-y-2 text-sm text-white/60">
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    {{ $user->company->address }}
                </p>
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    {{ $user->company->whatsapp }}
                </p>
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    {{ $user->company->products->count() }} produk
                </p>
            </div>
        </div>
    @endif

    @if($user->role === 'visitor')
        <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
            <h3 class="font-semibold mb-4">Aktivitas</h3>
            <div class="text-sm text-white/60">
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    {{ $user->bookmarks->count() }} UMKM difavoritkan
                </p>
            </div>
        </div>
    @endif

    <!-- Account Info -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <h3 class="font-semibold mb-4">Info Akun</h3>
        <div class="space-y-2 text-sm text-white/60">
            <p>Bergabung: {{ $user->created_at->format('d M Y, H:i') }}</p>
            <p>Terakhir update: {{ $user->updated_at->diffForHumans() }}</p>
        </div>
    </div>

    <!-- Manage User -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl space-y-4">
        <h3 class="font-semibold">Kelola User</h3>

        <!-- Update Role -->
        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label class="block text-sm font-medium mb-2">Ubah Role</label>
            <select name="role" required class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 mb-4">
                <option value="visitor" {{ $user->role === 'visitor' ? 'selected' : '' }}>Visitor</option>
                <option value="umkm" {{ $user->role === 'umkm' ? 'selected' : '' }}>UMKM</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <button type="submit" class="w-full bg-blue-500/20 border border-blue-500/30 hover:bg-blue-500/30 transition text-blue-400 py-3 px-4 rounded-lg font-medium">
                Update Role
            </button>
        </form>

        <!-- Toggle Status -->
        <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="w-full {{ $user->status === 'active' ? 'bg-yellow-500/20 border border-yellow-500/30 hover:bg-yellow-500/30 text-yellow-400' : 'bg-green-500/20 border border-green-500/30 hover:bg-green-500/30 text-green-400' }} transition py-3 px-4 rounded-lg font-medium">
                {{ $user->status === 'active' ? 'Nonaktifkan User' : 'Aktifkan User' }}
            </button>
        </form>

        <!-- Delete -->
        @if($user->id !== auth()->id())
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini? Data tidak bisa dikembalikan!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-500/20 border border-red-500/30 hover:bg-red-500/30 transition text-red-400 py-3 px-4 rounded-lg font-medium">
                    Hapus User
                </button>
            </form>
        @endif
    </div>
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
        class="flex flex-col items-center px-3 py-2 text-white/60 hover:text-white transition rounded-lg hover:bg-white/5 {{ request()->routeIs('admin.companies*') ? 'text-brand-accent bg-white/5' : '' }}"
    >
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        <span class="text-xs">UMKM</span>
    </a>
    <a 
        href="{{ route('admin.users.index') }}" 
        class="flex flex-col items-center px-3 py-2 text-brand-accent transition rounded-lg bg-white/5"
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
