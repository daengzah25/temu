@extends('layouts.app')

@section('title', 'Kelola User - Admin')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="card" style="background: #D1FAE5; border-left: 4px solid #10B981;">
            <p style="color: #065F46;">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="card" style="background: #FEE2E2; border-left: 4px solid #EF4444;">
            <p style="color: #991B1B;">{{ session('error') }}</p>
        </div>
    @endif

    <div class="card">
        <h2><i class="fas fa-users"></i> Kelola User</h2>
        <p class="text-sm text-gray">Total: {{ $users->total() }} user</p>
    </div>

    <!-- Filter Role -->
    <div class="card">
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px;">
            <a href="{{ route('admin.users.index', ['role' => 'all']) }}" class="btn" style="padding: 8px; font-size: 14px; background: {{ $role === 'all' ? '#3B82F6' : '#E5E7EB' }}; color: {{ $role === 'all' ? 'white' : '#6B7280' }}; text-decoration: none; text-align: center;">
                Semua
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="btn" style="padding: 8px; font-size: 14px; background: {{ $role === 'admin' ? '#F59E0B' : '#E5E7EB' }}; color: {{ $role === 'admin' ? 'white' : '#6B7280' }}; text-decoration: none; text-align: center;">
                Admin
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'umkm']) }}" class="btn" style="padding: 8px; font-size: 14px; background: {{ $role === 'umkm' ? '#3B82F6' : '#E5E7EB' }}; color: {{ $role === 'umkm' ? 'white' : '#6B7280' }}; text-decoration: none; text-align: center;">
                UMKM
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'visitor']) }}" class="btn" style="padding: 8px; font-size: 14px; background: {{ $role === 'visitor' ? '#10B981' : '#E5E7EB' }}; color: {{ $role === 'visitor' ? 'white' : '#6B7280' }}; text-decoration: none; text-align: center;">
                Visitor
            </a>
        </div>
    </div>

    <!-- List Users -->
    @forelse($users as $user)
        <div class="card" style="margin-bottom: 16px;">
            <div class="flex items-center gap mb2">
                <img src="{{ $user->avatar }}" alt="Avatar" style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid {{ $user->status === 'active' ? '#10B981' : '#EF4444' }};">
                <div style="flex: 1;">
                    <h3>{{ $user->name }}</h3>
                    <p class="text-sm text-gray">{{ $user->email }}</p>
                </div>
                <div style="text-align: right;">
                    <span style="background: {{ $user->role === 'admin' ? '#FEF3C7' : ($user->role === 'umkm' ? '#DBEAFE' : '#D1FAE5') }}; color: {{ $user->role === 'admin' ? '#92400E' : ($user->role === 'umkm' ? '#1E40AF' : '#065F46') }}; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; display: block; margin-bottom: 4px;">
                        {{ strtoupper($user->role) }}
                    </span>
                    <span style="background: {{ $user->status === 'active' ? '#D1FAE5' : '#FEE2E2' }}; color: {{ $user->status === 'active' ? '#065F46' : '#991B1B' }}; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; display: block;">
                        {{ $user->status === 'active' ? 'AKTIF' : 'BANNED' }}
                    </span>
                </div>
            </div>

            @if($user->role === 'umkm' && $user->company)
                <div class="text-sm text-gray mb2" style="background: #F9FAFB; padding: 12px; border-radius: 8px;">
                    <p class="mb"><i class="fas fa-store" style="width: 20px;"></i> UMKM: <strong>{{ $user->company->name }}</strong></p>
                    <p><i class="fas fa-circle" style="width: 20px; color: {{ $user->company->status === 'pending' ? '#F59E0B' : ($user->company->status === 'approved' ? '#10B981' : '#EF4444') }};"></i> Status: <strong>{{ strtoupper($user->company->status) }}</strong></p>
                </div>
            @endif

            <div class="text-sm text-gray mb2">
                <p><i class="fas fa-calendar" style="width: 20px;"></i> Bergabung: {{ $user->created_at->format('d M Y') }}</p>
            </div>

            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-block" style="background: #3B82F6; color: white; text-decoration: none; text-align: center;">
                <i class="fas fa-eye"></i> Lihat Detail
            </a>
        </div>
    @empty
        <div class="card text-center">
            <i class="fas fa-user-slash" style="font-size: 64px; color: #D1D5DB; margin-bottom: 16px;"></i>
            <h3>Tidak Ada User</h3>
            <p class="text-gray">Belum ada user dengan role {{ $role }}</p>
        </div>
    @endforelse

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="card">
            <div class="flex justify-between items-center">
                @if($users->onFirstPage())
                    <span style="color: #D1D5DB;">← Prev</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" style="color: #3B82F6; text-decoration: none;">← Prev</a>
                @endif

                <span class="text-sm text-gray">
                    Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
                </span>

                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" style="color: #3B82F6; text-decoration: none;">Next →</a>
                @else
                    <span style="color: #D1D5DB;">Next →</span>
                @endif
            </div>
        </div>
    @endif
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
