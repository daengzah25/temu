@extends('layouts.app')

@section('title', 'Home - Temu')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="card" style="background: #D1FAE5; border-left: 4px solid #10B981;">
            <p style="color: #065F46;">{{ session('success') }}</p>
        </div>
    @endif

    <div class="card text-center">
        <i class="fas fa-map-marker-alt text-blue" style="font-size: 64px; margin-bottom: 16px;"></i>
        <h2>Temukan UMKM Terdekat</h2>
        <p class="text-gray mb3">Cari dan hubungi UMKM di sekitar Anda</p>

        <button onclick="detectLocationAndSearch()" class="btn btn-primary btn-block">
            <i class="fas fa-search-location"></i> Cari UMKM Terdekat
        </button>
    </div>

    <div class="card">
        <h3 class="mb2">✨ Fitur Temu</h3>
        <div class="text-sm text-gray">
            <p class="mb">📍 Deteksi lokasi otomatis</p>
            <p class="mb">🏪 Ribuan UMKM terdaftar</p>
            <p class="mb">💬 Hubungi langsung via WhatsApp</p>
            <p>❤️ Simpan UMKM favorit</p>
        </div>
    </div>

    @auth
        @if(Auth::user()->role === 'visitor')
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-block" style="background: #6B7280; color: white;">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        @endif
    @endauth
</div>
@endsection

@section('bottom-nav')
<nav class="bottom-nav">
    <a href="{{ route('visitor.home') }}" class="active">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('visitor.nearby') }}">
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
function detectLocationAndSearch() {
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
