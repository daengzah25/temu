@extends('layouts.app')

@section('title', 'Kelola UMKM - Admin')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="card" style="background: #D1FAE5; border-left: 4px solid #10B981;">
            <p style="color: #065F46;">{{ session('success') }}</p>
        </div>
    @endif

    <div class="card">
        <h2><i class="fas fa-store"></i> Kelola UMKM</h2>
        <p class="text-sm text-gray">Total: {{ $companies->total() }} UMKM</p>
    </div>

    <!-- Filter Status -->
    <div class="card">
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px;">
            <a href="{{ route('admin.companies', ['status' => 'all']) }}" class="btn" style="padding: 8px; font-size: 14px; background: {{ $status === 'all' ? '#3B82F6' : '#E5E7EB' }}; color: {{ $status === 'all' ? 'white' : '#6B7280' }}; text-decoration: none; text-align: center;">
                Semua
            </a>
            <a href="{{ route('admin.companies', ['status' => 'pending']) }}" class="btn" style="padding: 8px; font-size: 14px; background: {{ $status === 'pending' ? '#F59E0B' : '#E5E7EB' }}; color: {{ $status === 'pending' ? 'white' : '#6B7280' }}; text-decoration: none; text-align: center;">
                Pending
            </a>
            <a href="{{ route('admin.companies', ['status' => 'approved']) }}" class="btn" style="padding: 8px; font-size: 14px; background: {{ $status === 'approved' ? '#10B981' : '#E5E7EB' }}; color: {{ $status === 'approved' ? 'white' : '#6B7280' }}; text-decoration: none; text-align: center;">
                Approved
            </a>
            <a href="{{ route('admin.companies', ['status' => 'rejected']) }}" class="btn" style="padding: 8px; font-size: 14px; background: {{ $status === 'rejected' ? '#EF4444' : '#E5E7EB' }}; color: {{ $status === 'rejected' ? 'white' : '#6B7280' }}; text-decoration: none; text-align: center;">
                Rejected
            </a>
        </div>
    </div>

    <!-- List UMKM -->
    @forelse($companies as $company)
        <div class="card" style="margin-bottom: 16px; border-left: 4px solid {{ $company->status === 'pending' ? '#F59E0B' : ($company->status === 'approved' ? '#10B981' : '#EF4444') }};">
            <div class="flex items-center gap mb2">
                @if($company->logo)
                    <img src="{{ $company->logo }}" alt="Logo" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                @else
                    <div style="width: 50px; height: 50px; background: #E5E7EB; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-store" style="color: #6B7280;"></i>
                    </div>
                @endif
                <div style="flex: 1;">
                    <h3>{{ $company->name }}</h3>
                    <p class="text-sm text-gray">{{ $company->category }}</p>
                </div>
                <span style="background: {{ $company->status === 'pending' ? '#FEF3C7' : ($company->status === 'approved' ? '#D1FAE5' : '#FEE2E2') }}; color: {{ $company->status === 'pending' ? '#92400E' : ($company->status === 'approved' ? '#065F46' : '#991B1B') }}; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                    {{ strtoupper($company->status) }}
                </span>
            </div>

            <div class="text-sm text-gray mb2">
                <p class="mb"><i class="fas fa-user" style="width: 20px;"></i> {{ $company->user->name }}</p>
                <p class="mb"><i class="fas fa-map-marker-alt" style="width: 20px;"></i> {{ Str::limit($company->address, 50) }}</p>
                <p><i class="fas fa-clock" style="width: 20px;"></i> Daftar: {{ $company->created_at->format('d M Y, H:i') }}</p>
            </div>

            <a href="{{ route('admin.company.show', $company->id) }}" class="btn btn-block" style="background: #3B82F6; color: white; text-decoration: none; text-align: center;">
                <i class="fas fa-eye"></i> Review Detail
            </a>
        </div>
    @empty
        <div class="card text-center">
            <i class="fas fa-inbox" style="font-size: 64px; color: #D1D5DB; margin-bottom: 16px;"></i>
            <h3>Tidak Ada UMKM</h3>
            <p class="text-gray">Belum ada UMKM dengan status {{ $status }}</p>
        </div>
    @endforelse

    <!-- Pagination -->
    @if($companies->hasPages())
        <div class="card">
            <div class="flex justify-between items-center">
                @if($companies->onFirstPage())
                    <span style="color: #D1D5DB;">← Prev</span>
                @else
                    <a href="{{ $companies->previousPageUrl() }}" style="color: #3B82F6; text-decoration: none;">← Prev</a>
                @endif

                <span class="text-sm text-gray">
                    Page {{ $companies->currentPage() }} of {{ $companies->lastPage() }}
                </span>

                @if($companies->hasMorePages())
                    <a href="{{ $companies->nextPageUrl() }}" style="color: #3B82F6; text-decoration: none;">Next →</a>
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
    <a href="{{ route('admin.companies') }}" class="active">
        <i class="fas fa-list"></i>
        <span>UMKM</span>
    </a>
    <a href="{{ route('admin.users.index') }}">
        <i class="fas fa-users"></i>
        <span>Users</span>
    </a>
    <a href="{{ route('profile.show') }}">
        <i class="fas fa-user"></i>
        <span>Profil</span>
    </a>
</nav>
@endsection
