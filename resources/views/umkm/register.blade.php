@extends('layouts.app')

@section('title', 'Daftar UMKM - Temu')

@section('content')
<div class="space-y-6">
    <div class="bg-surface border border-border p-6 rounded-lg2">
        <h2 class="text-xl font-bold flex items-center gap-2 mb-2 text-text">
            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            Daftar UMKM Anda
        </h2>
        <p class="text-sm text-muted">Lengkapi data usaha Anda untuk tampil di platform Temu</p>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-lg bg-red-500/10 dark:bg-red-500/20 border border-red-500/30">
            @foreach ($errors->all() as $error)
                <p class="text-red-700 dark:text-red-100 text-sm mb-1">• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('umkm.register') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-surface border border-border p-6 rounded-lg2">
            <h3 class="font-semibold mb-4 flex items-center gap-2 text-text">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Informasi Dasar
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2 text-text">Nama Usaha *</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Warung Makan Ibu Siti" required class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-text placeholder:text-muted/60">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Kategori *</label>
                    <select name="category" required class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-text">
                        <option value="">Pilih Kategori</option>
                        <option value="Makanan & Minuman" {{ old('category') == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
                        <option value="Fashion" {{ old('category') == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                        <option value="Jasa" {{ old('category') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                        <option value="Kerajinan" {{ old('category') == 'Kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                        <option value="Elektronik" {{ old('category') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                        <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Logo Usaha (Opsional)</label>
                    <input type="file" name="logo" accept="image/*" onchange="previewLogo(event)" class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-text file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-accent-contrast hover:file:bg-accent/90">
                    <img id="logoPreview" class="w-24 h-24 rounded-lg object-cover mt-3 hidden">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" placeholder="Ceritakan tentang usaha Anda..." class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-text placeholder:text-muted/60 resize-none">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-surface border border-border p-6 rounded-lg2">
            <h3 class="font-semibold mb-4 flex items-center gap-2 text-text">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Lokasi Usaha
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Alamat Lengkap *</label>
                    <textarea name="address" rows="2" placeholder="Jl. Merdeka No. 123, Bandung" required class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-text placeholder:text-muted/60 resize-none">{{ old('address') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Koordinat GPS *</label>
                    <div class="flex gap-3">
                        <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}" placeholder="Latitude" required class="flex-1 px-4 py-3 rounded-lg bg-surface/80 border border-border focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-text placeholder:text-muted/60">
                        <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}" placeholder="Longitude" required class="flex-1 px-4 py-3 rounded-lg bg-surface/80 border border-border focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-text placeholder:text-muted/60">
                    </div>
                </div>

                <button type="button" onclick="getLocation()" class="w-full px-4 py-3 rounded-lg bg-green-500 hover:bg-green-600 text-text font-medium transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Deteksi Lokasi Saya
                </button>

                <p class="text-sm text-muted" id="locationStatus"></p>
            </div>
        </div>

        <div class="bg-surface border border-border p-6 rounded-lg2">
            <h3 class="font-semibold mb-4 flex items-center gap-2 text-text">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                Kontak
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Nomor WhatsApp *</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08123456789" required class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-text placeholder:text-muted/60">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Jam Operasional</label>
                    <input type="text" name="operating_hours" value="{{ old('operating_hours') }}" placeholder="08:00 - 21:00" class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-text placeholder:text-muted/60">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full px-6 py-3 rounded-lg bg-accent text-accent-contrast font-semibold hover:bg-accent/90 transition flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Daftar Sekarang
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Preview logo
function previewLogo(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('logoPreview');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

// Get GPS location
function getLocation() {
    const status = document.getElementById('locationStatus');
    status.textContent = 'Mendeteksi lokasi...';
    status.className = 'text-sm text-blue-400';

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById('latitude').value = position.coords.latitude.toFixed(7);
                document.getElementById('longitude').value = position.coords.longitude.toFixed(7);
                status.textContent = '✅ Lokasi berhasil dideteksi!';
                status.className = 'text-sm text-green-400';
            },
            function(error) {
                status.textContent = '❌ Gagal mendeteksi lokasi. Izinkan akses lokasi di browser Anda.';
                status.className = 'text-sm text-red-400';
            }
        );
    } else {
        status.textContent = '❌ Browser Anda tidak mendukung GPS.';
        status.className = 'text-sm text-red-400';
    }
}
</script>
@endpush
