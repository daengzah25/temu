@extends('layouts.app')

@section('title', 'UMKM Terdekat - Temu UMKM')

@section('content')
<div class="space-y-4">
  @if($needLocation)
    <!-- Location Request -->
    <div class="text-center py-12">
      <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/10 mb-4">
        <svg class="w-10 h-10 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
      </div>
      <h2 class="text-2xl font-bold mb-2">Aktifkan Lokasi</h2>
      <p class="text-white/60 mb-6">Izinkan akses lokasi untuk menemukan UMKM terdekat</p>

      <button 
        onclick="detectLocation()" 
        class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-brand-accent text-black font-semibold hover:bg-brand-accent/90 transition"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Deteksi Lokasi Saya
      </button>
    </div>
  @else
    <!-- Search Bar -->
    @include('components.search-bar')

    <!-- Results Header -->
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold">UMKM Terdekat</h2>
        <p class="text-sm text-white/60 mt-1">
          {{ $companies->count() }} ditemukan dalam radius {{ $radius }} km
        </p>
      </div>
      <button 
        onclick="detectLocation()" 
        class="p-2 rounded-lg bg-white/8 border border-white/10 hover:bg-white/12 transition"
        title="Refresh Lokasi"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
      </button>
    </div>

    <!-- UMKM List -->
    <div class="space-y-4">
      @forelse($companies as $company)
        @include('components.umkm-card', ['umkm' => $company])
      @empty
        <div class="text-center py-12">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/10 mb-4">
            <svg class="w-8 h-8 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold mb-2">Tidak Ada UMKM</h3>
          <p class="text-white/60 text-sm">
            Tidak ada UMKM dalam radius {{ $radius }} km dari lokasi Anda
          </p>
        </div>
      @endforelse
    </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
function detectLocation() {
  if (!navigator.geolocation) {
    alert('Browser Anda tidak mendukung GPS.');
    return;
  }

  const loadingMsg = document.createElement('div');
  loadingMsg.className = 'fixed top-20 left-1/2 transform -translate-x-1/2 bg-brand-accent text-black px-4 py-2 rounded-lg z-50';
  loadingMsg.textContent = 'Mencari lokasi...';
  document.body.appendChild(loadingMsg);

  navigator.geolocation.getCurrentPosition(
    function(position) {
      const lat = position.coords.latitude;
      const lng = position.coords.longitude;
      loadingMsg.remove();
      window.location.href = `/nearby?lat=${lat}&lng=${lng}`;
    },
    function(error) {
      loadingMsg.remove();
      let errorMsg = 'Gagal mendeteksi lokasi.';
      if (error.code === error.PERMISSION_DENIED) {
        errorMsg = 'Akses lokasi ditolak. Silakan izinkan akses lokasi di pengaturan browser.';
      } else if (error.code === error.POSITION_UNAVAILABLE) {
        errorMsg = 'Informasi lokasi tidak tersedia.';
      } else if (error.code === error.TIMEOUT) {
        errorMsg = 'Waktu permintaan lokasi habis.';
      }
      alert(errorMsg);
    }
  );
}
</script>
@endpush
