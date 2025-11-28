@extends('layouts.app')

@section('title', 'Review UMKM - Admin')

@section('content')
<div class="space-y-6">
    @if (session('success'))
        <div class="p-4 rounded-lg bg-green-500/10 dark:bg-green-500/20 border border-green-500/30">
            <p class="text-green-700 dark:text-green-100">{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 rounded-lg bg-red-500/10 dark:bg-red-500/20 border border-red-500/30">
            @foreach ($errors->all() as $error)
                <p class="text-red-700 dark:text-red-100 text-sm">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Header -->
    <div class="bg-surface border border-border p-6 rounded-lg2">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 transition text-sm mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
        <h2 class="text-xl font-bold text-text">Review Pendaftaran UMKM</h2>
    </div>

    <!-- Company Info -->
    <div class="bg-surface border border-border p-6 rounded-lg2">
        @if ($company->logo)
            <img src="{{ $company->logo }}" alt="Logo" class="w-full max-w-[200px] h-[200px] object-cover rounded-xl mx-auto mb-6">
        @endif

        <h3 class="font-semibold mb-4 text-text">Informasi UMKM</h3>
        <div class="space-y-3 text-sm">
            <div>
                <p class="text-muted mb-1">Nama Usaha</p>
                <p class="font-medium text-text">{{ $company->name }}</p>
            </div>
            <div>
                <p class="text-muted mb-1">Kategori</p>
                <p class="font-medium text-text">{{ $company->category }}</p>
            </div>
            <div>
                <p class="text-muted mb-1">Deskripsi</p>
                <p class="font-medium text-text">{{ $company->description ?? '-' }}</p>
            </div>
            <div>
                <p class="text-muted mb-1">Alamat</p>
                <p class="font-medium text-text">{{ $company->address }}</p>
            </div>
            <div>
                <p class="text-muted mb-1">Koordinat</p>
                <p class="font-medium text-text">{{ $company->latitude }}, {{ $company->longitude }}</p>
            </div>
            <div>
                <p class="text-muted mb-1">WhatsApp</p>
                <p class="font-medium text-text">{{ $company->whatsapp }}</p>
            </div>
            <div>
                <p class="text-muted mb-1">Jam Operasional</p>
                <p class="font-medium text-text">{{ $company->operating_hours ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Owner Info -->
    <div class="bg-surface border border-border p-6 rounded-lg2">
        <h3 class="font-semibold mb-4 text-text">Pemilik</h3>
        <div class="flex items-center gap-4">
            <img src="{{ $company->user->avatar }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover">
            <div>
                <p class="font-semibold text-text">{{ $company->user->name }}</p>
                <p class="text-sm text-muted">{{ $company->user->email }}</p>
                <p class="text-sm text-muted">Daftar: {{ $company->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>

    @if ($company->status === 'pending')
        <!-- Approve Form -->
        <div class="bg-green-500/10 border border-green-500/20 p-6 rounded-lg2">
            <h3 class="font-semibold mb-4 text-green-400">Setujui Pendaftaran</h3>
            <form action="{{ route('admin.company.approve', $company->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-green-500/20 border border-green-500/30 hover:bg-green-500/30 transition text-green-400 py-3 px-4 rounded-lg font-medium">
                    Setujui UMKM Ini
                </button>
            </form>
        </div>

        <!-- Reject Form -->
        <div class="bg-red-500/10 border border-red-500/20 p-6 rounded-lg2">
            <h3 class="font-semibold mb-4 text-red-400">Tolak Pendaftaran</h3>
            <form action="{{ route('admin.company.reject', $company->id) }}" method="POST">
                @csrf
                <label class="block text-sm font-medium mb-2 text-text">Alasan Penolakan (Wajib) *</label>
                <textarea name="reason" rows="3" required class="w-full bg-surface/80 border border-border rounded-lg px-4 py-2 text-text placeholder-muted/60 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500/50 mb-4" placeholder="Contoh: Alamat tidak lengkap. Mohon sertakan nama jalan, nomor, dan kode pos."></textarea>
                <button type="submit" class="w-full bg-red-500/20 border border-red-500/30 hover:bg-red-500/30 transition text-red-400 py-3 px-4 rounded-lg font-medium">
                    Tolak Pendaftaran
                </button>
            </form>
        </div>
    @else
        <!-- Status Display -->
        <div class="bg-surface border border-border p-6 rounded-lg2 text-center">
            <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold {{ $company->status === 'approved' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                Status: {{ strtoupper($company->status) }}
            </span>
            @if ($company->rejection_reason)
                <p class="text-sm text-muted mt-4">Alasan: {{ $company->rejection_reason }}</p>
            @endif
        </div>
    @endif
</div>
@endsection
