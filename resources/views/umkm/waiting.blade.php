@extends('layouts.app')

@section('title', 'Menunggu Persetujuan - Temu')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-500/10 dark:bg-green-500/20 border border-green-500/30">
            <p class="text-green-700 dark:text-green-100">{{ session('success') }}</p>
        </div>
    @endif

    @if($company->status === 'pending')
        <div class="bg-surface border border-border p-6 rounded-lg2 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-yellow-500/20 mb-4">
                <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold mb-2 text-text">Menunggu Persetujuan Admin</h2>
            <p class="text-muted mb-6">Pendaftaran UMKM Anda sedang ditinjau oleh admin. Estimasi waktu: 1-2 hari kerja.</p>

            <div class="bg-yellow-500/10 border border-yellow-500/20 p-4 rounded-lg text-left mb-6">
                <h3 class="font-semibold mb-3 flex items-center gap-2 text-yellow-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Data yang Diajukan:
                </h3>
                <div class="space-y-2 text-sm text-text/80">
                    <p><strong class="text-text">Nama Usaha:</strong> {{ $company->name }}</p>
                    <p><strong class="text-text">Kategori:</strong> {{ $company->category }}</p>
                    <p><strong class="text-text">Alamat:</strong> {{ $company->address }}</p>
                    <p><strong class="text-text">WhatsApp:</strong> {{ $company->whatsapp }}</p>
                    @if($company->logo)
                        <div class="flex items-center gap-2 mt-2">
                            <strong class="text-text">Logo:</strong>
                            <img src="{{ $company->logo }}" class="w-12 h-12 rounded-lg object-cover">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @elseif($company->status === 'rejected')
        <div class="bg-surface border border-border p-6 rounded-lg2 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-500/20 mb-4">
                <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold mb-2 text-text">Pendaftaran Ditolak</h2>
            <p class="text-muted mb-6">Mohon maaf, pendaftaran UMKM Anda belum dapat disetujui.</p>

            <div class="bg-red-500/10 border border-red-500/20 p-4 rounded-lg text-left mb-6">
                <h3 class="font-semibold mb-2 flex items-center gap-2 text-red-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Alasan Penolakan:
                </h3>
                <p class="text-sm text-text/80">{{ $company->rejection_reason ?? 'Tidak ada alasan spesifik.' }}</p>
            </div>

            <a href="{{ route('umkm.register.form') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg2 bg-accent text-accent-contrast font-semibold hover:opacity-90 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Perbaiki & Daftar Ulang
            </a>
        </div>
    @endif

    <div class="bg-surface border border-border p-6 rounded-lg2">
        <h3 class="font-semibold mb-4 text-text">Sementara Menunggu, Anda Bisa:</h3>
        <div class="space-y-3 text-sm text-muted">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Siapkan foto produk berkualitas</span>
            </div>
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Tulis deskripsi produk yang menarik</span>
            </div>
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                <span>Pikirkan strategi promosi Anda</span>
            </div>
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                </svg>
                <span>Pelajari fitur AI Promosi yang akan tersedia</span>
            </div>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="w-full px-4 py-3 rounded-lg2 bg-surface border border-border hover:bg-surface/80 transition text-center flex items-center justify-center gap-2 text-text">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            Keluar
        </button>
    </form>
</div>
@endsection
