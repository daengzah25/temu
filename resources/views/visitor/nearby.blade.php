@extends('layouts.app')

@section('title', 'UMKM Terdekat - Temu')

@section('content')
<div class="container">
    @if($needLocation)
        <div class="card text-center">
            <i class="fas fa-map-marker-alt" style="font-size: 64px; color: #F59E0B; margin-bottom: 16px;"></i>
            <h2>Aktifkan Lokasi</h2>
            <p class="text-gray mb3">Izinkan akses lokasi untuk menemukan UMKM terdekat</p>

            <button onclick="detectLocation()" class="btn btn-primary btn-block">
                <i class="fas fa-crosshairs"></i> Deteksi Lokasi Saya
            </button>
        </div>
    @else
        <div class="card">
            <div class="flex justify-between items-center">
                <div>
                    <h2>UMKM Terdekat</h2>
                    <p class="text-sm text-gray">{{ $companies->count() }} ditemukan dalam radius {{ $radius }} km</p>
                </div>
                <button onclick="detectLocation()" style="background: #3B82F6; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer;">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        @forelse($companies as $company)
            <div class="card" style="margin-bottom: 16px;">
                <div class="flex gap">
                    @if($company->logo)
                        <img src="{{ $company->logo }}" alt="Logo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px;">
                    @else
                        <div style="width: 80px; height: 80px; background: #E5E7EB; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-store" style="font-size: 32px; color: #6B7280;"></i>
                        </div>
                    @endif

                    <div style="flex: 1;">
                        <h3>{{ $company->name }}</h3>
                        <p class="text-sm text-gray mb">
                            <i class="fas fa-tag" style="color: #3B82F6;"></i> {{ $company->category }}
                        </p>
                        <p class="text-sm text-gray mb">
                            <i class="fas fa-map-marker-alt" style="color: #EF4444;"></i> {{ number_format($company->distance_km, 1) }} km
                        </p>
                        @if($company->operating_hours)
                            <p class="text-sm text-gray">
                                <i class="fas fa-clock" style="color: #10B981;"></i> {{ $company->operating_hours }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex gap mt2">
                    <a href="{{ route('visitor.company.show', $company->slug) }}" class="btn" style="flex: 1; background: #3B82F6; color: white; text-decoration: none; padding: 10px; text-align: center;">
                        <i class="fas fa-info-circle"></i> Detail
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}" target="_blank" class="btn" style="flex: 1; background: #10B981; color: white; text-decoration: none; padding: 10px; text-align: center;">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </div>
            </div>
        @empty
            <div class="card text-center">
                <i class="fas fa-search" style="font-size: 64px; color: #D1D5DB; margin-bottom: 16px;"></i>
                <h3>Tidak Ada UMKM</h3>
                <p class="text-gray">Tidak ada UMKM dalam radius {{ $radius }} km dari lokasi Anda</p>
            </div>
        @endforelse
    @endif
</div>
@endsection

@section('bottom-nav')
<nav class="bottom-nav">
    <a href="{{ route('visitor.home') }}">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('visitor.nearby') }}" class="active">
        <i class="fas fa-search"></i>
        <span>Cari</span>
    </a>
    <a href="{{ route('bookmarks.index') }}">
        <i class="fas fa-heart"></i>
        <span>Favorit</span>
    </a>
    <a href="{{ route('profile.show') }}">
        <i class="fas fa-user"></i>
        <span>Profil</span>
    </a>
</nav>
@endsection

@push('scripts')
<script>
function detectLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                window.location.href = `/nearby?lat=${lat}&lng=${lng}`;
            },
            function(error) {
                alert('Gagal mendeteksi lokasi. Izinkan akses lokasi di browser Anda.');
            }
        );
    } else {
        alert('Browser Anda tidak mendukung GPS.');
    }
}
</script>
@endpush
