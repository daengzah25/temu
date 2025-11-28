@extends('layouts.app')

@section('title', 'UMKM Terdekat - Temu UMKM')

@section('content')
<div class="space-y-4">
  <!-- Search Bar -->
  @include('components.search-bar')

  @if($needLocation)

    <!-- Location Request -->
    <div class="text-center py-12">
      <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-surface/80 mb-4">
        <svg class="w-10 h-10 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
      </div>
      <h2 class="text-2xl font-bold mb-2 text-text">Aktifkan Lokasi</h2>
      <p class="text-muted mb-6">Izinkan akses lokasi untuk menemukan UMKM terdekat</p>

      <button
        onclick="detectLocation()"
        class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-accent text-black font-semibold hover:bg-accent/90 transition"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Deteksi Lokasi Saya
      </button>
    </div>
  @else
    <!-- Results Header -->
    <div class="flex items-center justify-between gap-2 flex-wrap">
      <div class="flex-1 min-w-0">
        <h2 class="text-xl font-bold text-text">
          @if(request('q'))
            Hasil Pencarian: "{{ request('q') }}"
          @else
            UMKM Terdekat
          @endif
        </h2>
        <p class="text-sm text-muted mt-1">
          {{ $companies->count() }} ditemukan dalam radius {{ $radius }} km
          @if(request('q'))
            untuk "{{ request('q') }}"
          @endif
        </p>
      </div>
      <div class="flex gap-1 md:gap-2 flex-shrink-0">
        <!-- Radius Selector -->
        <select id="radiusSelect" onchange="changeRadius(this.value)" class="px-2 md:px-3 py-2 rounded-lg bg-surface/80 border border-border text-text text-xs md:text-sm focus:outline-none focus:ring-2 focus:ring-accent">
          <option value="5">5 km</option>
          <option value="10">10 km</option>
          <option value="15">15 km</option>
          <option value="20">20 km</option>
          <option value="30">30 km</option>
          <option value="50">50 km</option>
          <option value="100">100 km</option>
        </select>

        <!-- Refresh Button -->
        <button
          onclick="refreshLocation()"
          class="p-2 rounded-lg bg-surface/80 border border-border hover:bg-white/12 transition flex-shrink-0"
          title="Refresh Lokasi"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- UMKM List -->
    <div class="space-y-4">
      @forelse($companies as $company)
        @include('components.umkm-card', ['umkm' => $company])
      @empty
        <div class="text-center py-12">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-surface/80 mb-4">
            <svg class="w-8 h-8 text-text/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold mb-2 text-text">Tidak Ada UMKM</h3>
          <p class="text-muted text-sm">
            @if(request('q'))
              Tidak ada UMKM yang sesuai dengan pencarian "{{ request('q') }}" dalam radius {{ $radius }} km dari lokasi Anda
            @else
              Tidak ada UMKM dalam radius {{ $radius }} km dari lokasi Anda
            @endif
          </p>
        </div>
      @endforelse
    </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
// Store location in localStorage untuk persistent
function saveLocationToStorage(lat, lng) {
  localStorage.setItem('user_location', JSON.stringify({ lat, lng, timestamp: Date.now() }));
}

function getStoredLocation() {
  const stored = localStorage.getItem('user_location');
  if (!stored) return null;

  const data = JSON.parse(stored);
  // Location valid untuk 1 jam
  const oneHourAgo = Date.now() - (60 * 60 * 1000);

  if (data.timestamp > oneHourAgo) {
    return data;
  }

  localStorage.removeItem('user_location');
  return null;
}

function changeRadius(radius) {
  // Get current params
  const urlParams = new URLSearchParams(window.location.search);
  const lat = urlParams.get('lat');
  const lng = urlParams.get('lng');
  const q = urlParams.get('q');

  let newUrl = `/nearby?lat=${lat}&lng=${lng}&radius_km=${radius}`;
  if (q) {
    newUrl += `&q=${encodeURIComponent(q)}`;
  }

  window.location.href = newUrl;
}

function refreshLocation() {
  // Refresh dengan detect location ulang, selalu reset ke radius 50km
  detectLocation();
}

function detectLocation() {
  if (!navigator.geolocation) {
    alert('Browser Anda tidak mendukung GPS.');
    return;
  }

  const loadingMsg = document.createElement('div');
  loadingMsg.className = 'fixed top-20 left-1/2 transform -translate-x-1/2 bg-accent text-accent-contrast px-4 py-2 rounded-lg z-50 font-medium';
  loadingMsg.textContent = 'Mencari lokasi...';
  document.body.appendChild(loadingMsg);

  // Timeout 15 detik
  const timeoutId = setTimeout(() => {
    loadingMsg.remove();
    alert('Timeout mencari lokasi. Pastikan GPS/Location sudah diaktifkan.');
  }, 15000);

  navigator.geolocation.getCurrentPosition(
    function(position) {
      clearTimeout(timeoutId);
      const lat = position.coords.latitude;
      const lng = position.coords.longitude;
      const accuracy = position.coords.accuracy;

      loadingMsg.remove();

      // Log untuk debugging
      console.log('Location detected:', { lat, lng, accuracy });

      // Save untuk later use
      saveLocationToStorage(lat, lng);

      // Preserve search query if exists
      const urlParams = new URLSearchParams(window.location.search);
      const searchQuery = urlParams.get('q');
      // Selalu gunakan 50km saat detect lokasi baru
      let redirectUrl = `/nearby?lat=${lat}&lng=${lng}&radius_km=50`;
      if (searchQuery) {
        redirectUrl += `&q=${encodeURIComponent(searchQuery)}`;
      }

      window.location.href = redirectUrl;
    },
    function(error) {
      clearTimeout(timeoutId);
      loadingMsg.remove();

      let errorMsg = 'Gagal mendeteksi lokasi.';

      if (error.code === error.PERMISSION_DENIED) {
        errorMsg = 'Akses lokasi ditolak. Silakan:\n1. Buka Settings\n2. Cari aplikasi browser\n3. Izinkan akses lokasi\n4. Refresh halaman ini';
      } else if (error.code === error.POSITION_UNAVAILABLE) {
        errorMsg = 'Informasi lokasi tidak tersedia. Coba lagi atau aktifkan GPS.';
      } else if (error.code === error.TIMEOUT) {
        errorMsg = 'Waktu permintaan lokasi habis. Coba lagi atau pastikan GPS aktif.';
      }

      console.error('Geolocation error:', error);
      alert(errorMsg);
    },
    {
      enableHighAccuracy: true,  // Gunakan GPS jika tersedia
      timeout: 10000,             // Timeout 10 detik
      maximumAge: 0               // Jangan gunakan cached location
    }
  );
}

// Try using stored location on page load if available
document.addEventListener('DOMContentLoaded', function() {
  // Sync radius selector dengan current radius dari URL
  const urlParams = new URLSearchParams(window.location.search);
  const currentRadius = urlParams.get('radius_km');
  if (currentRadius) {
    document.getElementById('radiusSelect').value = currentRadius;
  }

  // Check if we already have location in URL
  const hasLocation = urlParams.has('lat') && urlParams.has('lng');

  if (!hasLocation) {
    // Try using stored location
    const stored = getStoredLocation();
    if (stored) {
      console.log('Using stored location:', stored);
      let redirectUrl = `/nearby?lat=${stored.lat}&lng=${stored.lng}&radius_km=50`;
      const searchQuery = urlParams.get('q');
      if (searchQuery) {
        redirectUrl += `&q=${encodeURIComponent(searchQuery)}`;
      }
      window.location.href = redirectUrl;
    }
  }
});
</script>
@endpush
