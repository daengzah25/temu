@extends('layouts.app')

@section('title', 'Detail User - Admin')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="card" style="background: #D1FAE5; border-left: 4px solid #10B981;">
            <p style="color: #065F46;">{{ session('success') }}</p>
        </div>
    @endif

    <div class="card">
        <a href="{{ route('admin.users.index') }}" class="text-blue text-sm mb2" style="display: inline-block;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h2>Detail User</h2>
    </div>

    <div class="card text-center">
        <img src="{{ $user->avatar }}" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 16px; border: 4px solid {{ $user->status === 'active' ? '#10B981' : '#EF4444' }};">
        <h2>{{ $user->name }}</h2>
        <p class="text-sm text-gray mb2">{{ $user->email }}</p>
        <div style="display: flex; gap: 8px; justify-content: center;">
            <span style="background: {{ $user->role === 'admin' ? '#FEF3C7' : ($user->role === 'umkm' ? '#DBEAFE' : '#D1FAE5') }}; color: {{ $user->role === 'admin' ? '#92400E' : ($user->role === 'umkm' ? '#1E40AF' : '#065F46') }}; padding: 4px 16px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                {{ strtoupper($user->role) }}
            </span>
            <span style="background: {{ $user->status === 'active' ? '#D1FAE5' : '#FEE2E2' }}; color: {{ $user->status === 'active' ? '#065F46' : '#991B1B' }}; padding: 4px 16px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                {{ $user->status === 'active' ? 'AKTIF' : 'BANNED' }}
            </span>
        </div>
    </div>

    @if($user->role === 'umkm' && $user->company)
        <div class="card">
            <h3 class="mb2">🏪 Info UMKM</h3>
            <div class="flex items-center gap mb2">
                @if($user->company->logo)
                    <img src="{{ $user->company->logo) }}" alt="Logo" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                @endif
                <div style="flex: 1;">
                    <h3>{{ $user->company->name }}</h3>
                    <p class="text-sm text-gray">{{ $user->company->category }}</p>
                </div>
                <span style="background: {{ $user->company->status === 'pending' ? '#FEF3C7' : ($user->company->status === 'approved' ? '#D1FAE5' : '#FEE2E2') }}; color: {{ $user->company->status === 'pending' ? '#92400E' : ($user->company->status === 'approved' ? '#065F46' : '#991B1B') }}; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                    {{ strtoupper($user->company->status) }}
                </span>
            </div>
            <div class="text-sm text-gray">
                <p class="mb">📍 {{ $user->company->address }}</p>
                <p class="mb">📱 {{ $user->company->whatsapp }}</p>
                <p>📦 {{ $user->company->products->count() }} produk</p>
            </div>
        </div>
    @endif

    @if($user->role === 'visitor')
        <div class="card">
            <h3 class="mb2">📊 Aktivitas</h3>
            <div class="text-sm text-gray">
                <p>❤️ {{ $user->bookmarks->count() }} UMKM difavoritkan</p>
            </div>
        </div>
    @endif

    <div class="card">
        <h3 class="mb2">📅 Info Akun</h3>
        <div class="text-sm text-gray">
            <p class="mb">Bergabung: {{ $user->created_at->format('d M Y, H:i') }}</p>
            <p>Terakhir update: {{ $user->updated_at->diffForHumans() }}</p>
        </div>
    </div>

    <div class="card">
        <h3 class="mb2">⚙️ Kelola User</h3>

        <!-- Ubah Role -->
        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="mb2">
            @csrf
            @method('PUT')
            <label>Ubah Role</label>
            <select name="role" required style="margin-bottom: 8px;">
                <option value="visitor" {{ $user->role === 'visitor' ? 'selected' : '' }}>Visitor</option>
                <option value="umkm" {{ $user->role === 'umkm' ? 'selected' : '' }}>UMKM</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <button type="submit" class="btn btn-block" style="background: #3B82F6; color: white;">
                <i class="fas fa-save"></i> Update Role
            </button>
        </form>

        <!-- Ban/Unban -->
        <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST" class="mb2">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-block" style="background: {{ $user->status === 'active' ? '#F59E0B' : '#10B981' }}; color: white;">
                <i class="fas fa-{{ $user->status === 'active' ? 'ban' : 'check' }}"></i>
                {{ $user->status === 'active' ? 'Nonaktifkan User' : 'Aktifkan User' }}
            </button>
        </form>

        <!-- Hapus -->
        @if($user->id !== auth()->id())
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini? Data tidak bisa dikembalikan!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-block" style="background: #EF4444; color: white;">
                    <i class="fas fa-trash"></i> Hapus User
                </button>
            </form>
        @endif
    </div>
</div>
@endsection

@section('bottom-nav')
<nav class="bottom-nav">
    <a href="{{ route('admin.dashboard') }}">
        <i class="fas fa-crown"></i>
        <span>Admin</span>
    </a>
    <a href="{{ route('admin.companies') }}">
        <i class="fas fa-list"></i>
        <span>UMKM</span>
    </a>
    <a href="{{ route('admin.users.index') }}" class="active">
        <i class="fas fa-users"></i>
        <span>User</span>
    </a>
    <a href="{{ route('profile.show') }}">
        <i class="fas fa-user"></i>
        <span>Profil</span>
    </a>
</nav>
@endsection
