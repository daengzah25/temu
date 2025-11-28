@extends('layouts.app')

@section('title', 'Detail User - Admin')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-500/10 dark:bg-green-500/20 border border-green-500/30">
            <p class="text-green-700 dark:text-green-100">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-surface border border-border p-6 rounded-lg2">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 transition text-sm mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
        <h2 class="text-xl font-bold text-text">Detail User</h2>
    </div>

    <!-- User Profile -->
    <div class="bg-surface border border-border p-6 rounded-lg2 text-center">
        <img src="{{ $user->avatar }}" alt="Avatar" class="w-24 h-24 rounded-full mx-auto mb-4 border-4 {{ $user->status === 'active' ? 'border-green-500/50' : 'border-red-500/50' }}">
        <h2 class="text-xl font-bold mb-2 text-text">{{ $user->name }}</h2>
        <p class="text-sm text-muted mb-4">{{ $user->email }}</p>
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
        <div class="bg-surface border border-border p-6 rounded-lg2">
            <h3 class="font-semibold mb-4 text-text">Info UMKM</h3>
            <div class="flex items-center gap-4 mb-4">
                @if($user->company->logo)
                    <img src="{{ $user->company->logo }}" alt="Logo" class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                @endif
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold truncate text-text">{{ $user->company->name }}</h3>
                    <p class="text-sm text-muted">{{ $user->company->category }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->company->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : ($user->company->status === 'approved' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400') }}">
                    {{ strtoupper($user->company->status) }}
                </span>
            </div>
            <div class="space-y-2 text-sm text-muted">
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
        <div class="bg-surface border border-border p-6 rounded-lg2">
            <h3 class="font-semibold mb-4 text-text">Aktivitas</h3>
            <div class="text-sm text-muted">
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
    <div class="bg-surface border border-border p-6 rounded-lg2">
        <h3 class="font-semibold mb-4 text-text">Info Akun</h3>
        <div class="space-y-2 text-sm text-muted">
            <p>Bergabung: {{ $user->created_at->format('d M Y, H:i') }}</p>
            <p>Terakhir update: {{ $user->updated_at->diffForHumans() }}</p>
        </div>
    </div>

    <!-- Manage User -->
    <div class="bg-surface border border-border p-6 rounded-lg2 space-y-4">
        <h3 class="font-semibold text-text">Kelola User</h3>

        <!-- Update Role -->
        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label class="block text-sm font-medium mb-2 text-text">Ubah Role</label>
            <select name="role" required class="w-full bg-surface/80 border border-border rounded-lg px-4 py-2 text-text focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 mb-4">
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
