<div class="mt-4">
  <form id="searchForm" action="{{ route('visitor.nearby') }}" method="GET" class="flex gap-2 flex-wrap md:flex-nowrap">
    <input 
      type="text" 
      name="q" 
      placeholder="Cari UMKM, produk, kategori..." 
      value="{{ request('q') }}"
      class="flex-1 min-w-0 px-3 md:px-4 py-2 md:py-3 rounded-lg bg-surface border border-border placeholder:text-muted focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-text text-sm md:text-base" 
    />
    @if(request('lat') && request('lng'))
      <input type="hidden" name="lat" value="{{ request('lat') }}">
      <input type="hidden" name="lng" value="{{ request('lng') }}">
      @if(request('radius_km'))
        <input type="hidden" name="radius_km" value="{{ request('radius_km') }}">
      @endif
    @endif
    <button 
      type="button" 
      id="useLocation" 
      class="px-2 md:px-3 py-2 md:py-3 rounded-lg bg-surface border border-border hover:bg-surface/80 transition text-text flex-shrink-0"
      title="Gunakan Lokasi Saya"
    >
      <svg class="w-4 md:w-5 h-4 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
      </svg>
    </button>
    <button 
      type="submit" 
      class="px-3 md:px-4 py-2 md:py-3 rounded-lg bg-accent text-accent-contrast font-medium hover:bg-accent/90 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent text-sm md:text-base flex-shrink-0"
    >
      Cari
    </button>
  </form>
  <p id="locationMsg" class="text-xs mt-2 text-muted"></p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const useLocationBtn = document.getElementById('useLocation');
  const locationMsg = document.getElementById('locationMsg');
  const form = document.getElementById('searchForm');

  if (useLocationBtn) {
    useLocationBtn.addEventListener('click', function() {
      if (!navigator.geolocation) {
        locationMsg.textContent = 'Geolocation tidak didukung oleh browser Anda.';
        return;
      }

      locationMsg.textContent = 'Mencari lokasi...';
      useLocationBtn.disabled = true;

      navigator.geolocation.getCurrentPosition(
        function(position) {
          const { latitude, longitude } = position.coords;
          
          // Hapus input lat/lng yang sudah ada
          const existingLat = form.querySelector('input[name="lat"]');
          const existingLng = form.querySelector('input[name="lng"]');
          if (existingLat) existingLat.remove();
          if (existingLng) existingLng.remove();
          
          // Tambahkan input lat/lng baru
          const latInput = document.createElement('input');
          latInput.type = 'hidden';
          latInput.name = 'lat';
          latInput.value = latitude;
          form.appendChild(latInput);
          
          const lngInput = document.createElement('input');
          lngInput.type = 'hidden';
          lngInput.name = 'lng';
          lngInput.value = longitude;
          form.appendChild(lngInput);
          
          // Search query akan otomatis terkirim karena sudah ada di form
          locationMsg.textContent = 'Lokasi ditemukan. Menampilkan UMKM terdekat...';
          form.submit();
        },
        function(error) {
          let errorMsg = 'Izin lokasi ditolak atau gagal.';
          if (error.code === error.PERMISSION_DENIED) {
            errorMsg = 'Akses lokasi ditolak. Silakan izinkan akses lokasi di pengaturan browser.';
          } else if (error.code === error.POSITION_UNAVAILABLE) {
            errorMsg = 'Informasi lokasi tidak tersedia.';
          } else if (error.code === error.TIMEOUT) {
            errorMsg = 'Waktu permintaan lokasi habis.';
          }
          locationMsg.textContent = errorMsg;
          useLocationBtn.disabled = false;
        }
      );
    });
  }
});
</script>

