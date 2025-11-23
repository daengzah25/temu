@extends('layouts.app')

@section('title', 'Daftar UMKM - Temu')

@section('content')
<div class="container">
    <div class="card">
        <h2><i class="fas fa-store text-blue"></i> Daftar UMKM Anda</h2>
        <p class="text-sm text-gray mb2">Lengkapi data usaha Anda untuk tampil di platform Temu</p>
    </div>

    @if ($errors->any())
        <div class="card" style="background: #FEE2E2; border-left: 4px solid #EF4444;">
            @foreach ($errors->all() as $error)
                <p style="color: #991B1B; font-size: 14px;" class="mb">• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('umkm.register') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card">
            <h3 class="mb2">Informasi Dasar</h3>

            <label>Nama Usaha *</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Warung Makan Ibu Siti" required>

            <label>Kategori *</label>
            <select name="category" required>
                <option value="">Pilih Kategori</option>
                <option value="Makanan & Minuman" {{ old('category') == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
                <option value="Fashion" {{ old('category') == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                <option value="Jasa" {{ old('category') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                <option value="Kerajinan" {{ old('category') == 'Kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                <option value="Elektronik" {{ old('category') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>

            <label>Logo Usaha (Opsional)</label>
            <input type="file" name="logo" accept="image/*" onchange="previewLogo(event)">
            <img id="logoPreview" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; margin-top: 8px; display: none;">

            <label>Deskripsi Singkat</label>
            <textarea name="description" rows="3" placeholder="Ceritakan tentang usaha Anda...">{{ old('description') }}</textarea>
        </div>

        <div class="card">
            <h3 class="mb2">Lokasi Usaha</h3>

            <label>Alamat Lengkap *</label>
            <textarea name="address" rows="2" placeholder="Jl. Merdeka No. 123, Bandung" required>{{ old('address') }}</textarea>

            <label>Koordinat GPS *</label>
            <div class="flex gap" style="margin-bottom: 16px;">
                <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}" placeholder="Latitude" required style="flex: 1; margin-bottom: 0;">
                <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}" placeholder="Longitude" required style="flex: 1; margin-bottom: 0;">
            </div>

            <button type="button" class="btn" onclick="getLocation()" style="background: #10B981; color: white; width: 100%;">
                <i class="fas fa-map-marker-alt"></i> Deteksi Lokasi Saya
            </button>

            <p class="text-sm text-gray mt" id="locationStatus"></p>
        </div>

        <div class="card">
            <h3 class="mb2">Kontak</h3>

            <label>Nomor WhatsApp *</label>
            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08123456789" required>

            <label>Jam Operasional</label>
            <input type="text" name="operating_hours" value="{{ old('operating_hours') }}" placeholder="08:00 - 21:00">
        </div>

        <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-check"></i> Daftar Sekarang
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
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}

// Get GPS location
function getLocation() {
    const status = document.getElementById('locationStatus');
    status.textContent = 'Mendeteksi lokasi...';
    status.style.color = '#3B82F6';

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById('latitude').value = position.coords.latitude.toFixed(7);
                document.getElementById('longitude').value = position.coords.longitude.toFixed(7);
                status.textContent = '✅ Lokasi berhasil dideteksi!';
                status.style.color = '#10B981';
            },
            function(error) {
                status.textContent = '❌ Gagal mendeteksi lokasi. Izinkan akses lokasi di browser Anda.';
                status.style.color = '#EF4444';
            }
        );
    } else {
        status.textContent = '❌ Browser Anda tidak mendukung GPS.';
        status.style.color = '#EF4444';
    }
}
</script>
@endpush
