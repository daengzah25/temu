@extends('layouts.app')

@section('title', 'Kelola User - Admin')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-500/10 dark:bg-green-500/20 border border-green-500/30">
            <p class="text-green-700 dark:text-green-100">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-lg bg-red-500/10 dark:bg-red-500/20 border border-red-500/30">
            <p class="text-red-700 dark:text-red-100">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-surface border border-border p-6 rounded-lg2">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-lg bg-purple-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-text">Kelola User</h2>
                <p class="text-sm text-muted">Total: {{ $users->total() }} user</p>
            </div>
        </div>
    </div>

    <!-- Filter Role -->
    <div class="bg-surface border border-border p-6 rounded-lg2">
        <div class="grid grid-cols-4 gap-2">
            <a href="{{ route('admin.users.index', ['role' => 'all']) }}" class="py-2 px-3 rounded-lg text-center text-sm font-medium transition {{ $role === 'all' ? 'bg-blue-500/20 border border-blue-500/30 text-blue-400' : 'bg-surface/80 border border-border text-muted hover:bg-surface' }}">
                Semua
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="py-2 px-3 rounded-lg text-center text-sm font-medium transition {{ $role === 'admin' ? 'bg-yellow-500/20 border border-yellow-500/30 text-yellow-400' : 'bg-surface/80 border border-border text-muted hover:bg-surface' }}">
                Admin
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'umkm']) }}" class="py-2 px-3 rounded-lg text-center text-sm font-medium transition {{ $role === 'umkm' ? 'bg-blue-500/20 border border-blue-500/30 text-blue-400' : 'bg-surface/80 border border-border text-muted hover:bg-surface' }}">
                UMKM
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'visitor']) }}" class="py-2 px-3 rounded-lg text-center text-sm font-medium transition {{ $role === 'visitor' ? 'bg-green-500/20 border border-green-500/30 text-green-400' : 'bg-surface/80 border border-border text-muted hover:bg-surface' }}">
                Visitor
            </a>
        </div>
    </div>

    <!-- List Users -->
    @forelse($users as $user)
        <div class="bg-surface border border-border p-6 rounded-lg2">
            <div class="flex items-center gap-4 mb-4">
                <img src="{{ $user->avatar }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover border-2 {{ $user->status === 'active' ? 'border-green-500/50' : 'border-red-500/50' }}">
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold truncate text-text">{{ $user->name }}</h3>
                    <p class="text-sm text-muted truncate">{{ $user->email }}</p>
                </div>
                <div class="flex flex-col gap-1 items-end">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->role === 'admin' ? 'bg-yellow-500/20 text-yellow-400' : ($user->role === 'umkm' ? 'bg-blue-500/20 text-blue-400' : 'bg-green-500/20 text-green-400') }}">
                        {{ strtoupper($user->role) }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                        {{ $user->status === 'active' ? 'AKTIF' : 'BANNED' }}
                    </span>
                </div>
            </div>

            @if($user->role === 'umkm' && $user->company)
                <div class="bg-surface/80 border border-border p-4 rounded-lg mb-4">
                    <p class="text-sm text-muted mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        UMKM: <strong class="text-text">{{ $user->company->name }}</strong>
                    </p>
                    <p class="text-sm text-muted flex items-center gap-2">
                        <svg class="w-4 h-4 {{ $user->company->status === 'pending' ? 'text-yellow-400' : ($user->company->status === 'approved' ? 'text-green-400' : 'text-red-400') }}" fill="currentColor" viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="5"></circle>
                        </svg>
                        Status: <strong class="text-text">{{ strtoupper($user->company->status) }}</strong>
                    </p>
                </div>
            @endif

            <div class="text-sm text-muted mb-4">
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Bergabung: {{ $user->created_at->format('d M Y') }}
                </p>
            </div>

            <a href="{{ route('admin.users.show', $user->id) }}" class="block w-full bg-blue-500/10 border border-blue-500/20 hover:bg-blue-500/15 transition text-blue-400 text-center py-2 px-4 rounded-lg text-sm font-medium">
                Lihat Detail
            </a>
        </div>
    @empty
        <div class="bg-surface border border-border p-12 rounded-lg2 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-muted/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            <h3 class="font-semibold mb-2 text-text">Tidak Ada User</h3>
            <p class="text-muted">Belum ada user dengan role {{ $role }}</p>
        </div>
    @endforelse

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="bg-surface border border-border p-4 rounded-lg2">
            <div class="flex justify-between items-center">
                @if($users->onFirstPage())
                    <span class="text-muted/60">← Prev</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="text-blue-400 hover:text-blue-300 transition">← Prev</a>
                @endif

                <span class="text-sm text-muted">
                    Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
                </span>

                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="text-blue-400 hover:text-blue-300 transition">Next →</a>
                @else
                    <span class="text-muted/60">Next →</span>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
