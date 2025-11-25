@extends('layouts.app')

@section('title', 'Menunggu Persetujuan - Temu')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="card" style="background: #D1FAE5; border-left: 4px solid #10B981;">
            <p style="color: #065F46;">{{ session('success') }}</p>
        </div>
    @endif

    @if($company->status === 'pending')
        <div class="card text-center">
            <i class="fas fa-clock" style="font-size: 64px; color: #F59E0B; margin-bottom: 16px;"></i>
            <h2>Menunggu Persetujuan Admin</h2>
            <p class="text-gray mb3">Pendaftaran UMKM Anda sedang ditinjau oleh admin. Estimasi waktu: 1-2 hari kerja.</p>

            <div class="card" style="background: #FEF3C7; text-align: left;">
                <h3 class="mb2"><i class="fas fa-info-circle" style="color: #F59E0B;"></i> Data yang Diajukan:</h3>
                <div class="text-sm">
                    <p class="mb"><strong>Nama Usaha:</strong> {{ $company->name }}</p>
                    <p class="mb"><strong>Kategori:</strong> {{ $company->category }}</p>
                    <p class="mb"><strong>Alamat:</strong> {{ $company->address }}</p>
                    <p class="mb"><strong>WhatsApp:</strong> {{ $company->whatsapp }}</p>
                    @if($company->logo)
                        <p class="mb"><strong>Logo:</strong> <img src="{{ $company->logo }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; vertical-align: middle;"></p>
                    @endif
                </div>
            </div>
        </div>
    @elseif($company->status === 'rejected')
        <div class="card text-center">
            <i class="fas fa-times-circle" style="font-size: 64px; color: #EF4444; margin-bottom: 16px;"></i>
            <h2 style="color: #EF4444;">Pendaftaran Ditolak</h2>
            <p class="text-gray mb3">Mohon maaf, pendaftaran UMKM Anda belum dapat disetujui.</p>

            <div class="card" style="background: #FEE2E2; text-align: left;">
                <h3 class="mb2"><i class="fas fa-exclamation-triangle" style="color: #EF4444;"></i> Alasan Penolakan:</h3>
                <p class="text-sm">{{ $company->rejection_reason ?? 'Tidak ada alasan spesifik.' }}</p>
            </div>

            <a href="{{ route('umkm.register.form') }}" class="btn btn-primary btn-block mt2">
                <i class="fas fa-edit"></i> Perbaiki & Daftar Ulang
            </a>
        </div>
    @endif

    <div class="card">
        <h3 class="mb2">Sementara Menunggu, Anda Bisa:</h3>
        <div class="text-sm text-gray">
            <p class="mb">📱 Siapkan foto produk berkualitas</p>
            <p class="mb">📝 Tulis deskripsi produk yang menarik</p>
            <p class="mb">💡 Pikirkan strategi promosi Anda</p>
            <p>✨ Pelajari fitur AI Promosi yang akan tersedia</p>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-block" style="background: #6B7280; color: white;">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </button>
    </form>
</div>
@endsection
