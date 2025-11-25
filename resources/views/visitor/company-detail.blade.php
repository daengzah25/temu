@extends('layouts.app')

@section('title', $company->name . ' - Temu')

@section('content')
<div class="container">
    <div class="card">
        <a href="{{ route('visitor.nearby') }}" class="text-blue text-sm mb2" style="display: inline-block;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        @if($company->logo)
            <img src="{{ $company->logo }}" alt="Logo" style="width: 100%; max-width: 300px; height: 300px; object-fit: cover; border-radius: 12px; margin: 0 auto 16px; display: block;">
        @endif

        <h2 class="text-center">{{ $company->name }}</h2>
        <p class="text-center text-sm text-gray mb3">{{ $company->category }}</p>

        <div class="card" style="background: #F9FAFB;">
            <h3 class="mb2">📋 Informasi</h3>
            <div class="text-sm" style="line-height: 2;">
                @if($company->description)
                    <p class="mb2">{{ $company->description }}</p>
                @endif
                <p><i class="fas fa-map-marker-alt" style="width: 20px; color: #EF4444;"></i> {{ $company->address }}</p>
                <p><i class="fas fa-phone" style="width: 20px; color: #10B981;"></i> {{ $company->whatsapp }}</p>
                @if($company->operating_hours)
                    <p><i class="fas fa-clock" style="width: 20px; color: #F59E0B;"></i> {{ $company->operating_hours }}</p>
                @endif
            </div>
        </div>

        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}?text=Halo%20{{ urlencode($company->name) }},%20saya%20tertarik%20dengan%20produk%20Anda" target="_blank" class="btn btn-block" style="background: #10B981; color: white; text-decoration: none;">
            <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
        </a>

        @auth
            @php
                $isBookmarked = Auth::user()->bookmarks()->where('company_id', $company->id)->exists();
            @endphp
            <button onclick="toggleBookmark({{ $company->id }})" id="bookmarkBtn" class="btn btn-block" style="background: {{ $isBookmarked ? '#EF4444' : '#6B7280' }}; color: white;">
                <i class="fas fa-heart"></i>
                <span id="bookmarkText">{{ $isBookmarked ? 'Hapus dari Favorit' : 'Simpan ke Favorit' }}</span>
            </button>
        @else
            <a href="{{ route('auth.google') }}" class="btn btn-block" style="background: #6B7280; color: white; text-decoration: none;">
                <i class="fas fa-heart"></i> Login untuk Simpan Favorit
            </a>
        @endauth
    </div>

    @if($company->products->count() > 0)
        <div class="card">
            <h3 class="mb2">🛍️ Produk ({{ $company->products->count() }})</h3>

            @foreach($company->products as $product)
                <div class="card" style="background: #F9FAFB; margin-bottom: 12px;">
                    @if($product->images->count() > 0)
                        <img src="{{ $product->images->first()->image_path }}" alt="Produk" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 12px;">
                    @endif
                    <h3>{{ $product->name }}</h3>
                    <p class="text-sm text-gray mb2">{{ $product->description }}</p>
                    <div class="flex justify-between items-center">
                        <p style="font-size: 20px; font-weight: 700; color: #10B981;">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray">Stok: {{ $product->stock }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('bottom-nav')
<nav class="bottom-nav">
    <a href="{{ route('visitor.home') }}">
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
@auth
<script>
function toggleBookmark(companyId) {
    const btn = document.getElementById('bookmarkBtn');
    const text = document.getElementById('bookmarkText');

    fetch(`/bookmark/${companyId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.bookmarked) {
                btn.style.background = '#EF4444';
                text.textContent = 'Hapus dari Favorit';
            } else {
                btn.style.background = '#6B7280';
                text.textContent = 'Simpan ke Favorit';
            }

            // Show toast notification
            showToast(data.message);
        }
    })
    .catch(error => {
        alert('Gagal memproses bookmark');
    });
}

function showToast(message) {
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.style.cssText = 'position: fixed; top: 80px; left: 50%; transform: translateX(-50%); background: #1F2937; color: white; padding: 12px 24px; border-radius: 8px; z-index: 9999;';
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 2000);
}
</script>
@endauth
@endpush
