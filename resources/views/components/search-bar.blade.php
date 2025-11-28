<div class="mt-4">
  <form id="searchForm" action="{{ route('visitor.nearby') }}" method="GET" class="flex gap-2">
    <input 
      type="text" 
      name="q" 
      placeholder="Cari UMKM, produk, kategori..." 
      value="{{ request('q') }}"
      class="flex-1 px-4 py-3 rounded-lg bg-white/5 border border-white/10 placeholder:text-white/60 focus:outline-none focus:ring-2 focus:ring-brand-accent focus:border-transparent text-white" 
    />
    <button 
      type="button" 
      id="useLocation" 
      class="px-3 py-3 rounded-lg bg-white/8 border border-white/10 hover:bg-white/12 transition"
      title="Gunakan Lokasi Saya"
    >
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
      </svg>
    </button>
    <button 
      type="submit" 
      class="px-4 py-3 rounded-lg bg-brand-accent text-black font-medium hover:bg-brand-accent/90 transition"
    >
      Cari
    </button>
  </form>
  <p id="locationMsg" class="text-xs mt-2 text-white/60"></p>
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
          
          // Tambahkan input lat/lng jika belum ada
          let latInput = form.querySelector('input[name="lat"]');
          let lngInput = form.querySelector('input[name="lng"]');
          
          if (!latInput) {
            latInput = document.createElement('input');
            latInput.type = 'hidden';
            latInput.name = 'lat';
            form.appendChild(latInput);
          }
          
          if (!lngInput) {
            lngInput = document.createElement('input');
            lngInput.type = 'hidden';
            lngInput.name = 'lng';
            form.appendChild(lngInput);
          }
          
          latInput.value = latitude;
          lngInput.value = longitude;
          
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

