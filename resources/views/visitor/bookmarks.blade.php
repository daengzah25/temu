@extends('layouts.app')

@section('title', 'Favorit Saya - Temu')

@section('content')
<div class="container">
    <div class="card">
        <h2><i class="fas fa-heart" style="color: #EF4444;"></i> Favorit Saya</h2>
        <p class="text-sm text-gray">{{ $bookmarks->count() }} UMKM tersimpan</p>
    </div>

    @forelse($bookmarks as $bookmark)
        @php $company = $bookmark->company; @endphp
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
                    <p class="text-sm text-gray">
                        <i class="fas fa-map-marker-alt" style="color: #EF4444;"></i> {{ Str::limit($company->address, 40) }}
                    </p>
                </div>
            </div>

            <div class="flex gap mt2">
                <a href="{{ route('visitor.company.show', $company->slug) }}" class="btn" style="flex: 1; background: #3B82F6; color: white; text-decoration: none; padding: 10px; text-align: center;">
                    <i class="fas fa-info-circle"></i> Detail
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}" target="_blank" class="btn" style="flex: 1; background: #10B981; color: white; text-decoration: none; padding: 10px; text-align: center;">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
                <button onclick="toggleBookmark({{ $company->id }}, this)" class="btn" style="background: #EF4444; color: white; padding: 10px 16px;">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    @empty
        <div class="card text-center">
            <i class="fas fa-heart-broken" style="font-size: 64px; color: #D1D5DB; margin-bottom: 16px;"></i>
            <h3>Belum Ada Favorit</h3>
            <p class="text-gray mb3">Simpan UMKM favorit Anda untuk akses cepat</p>
            <a href="{{ route('visitor.nearby') }}" class="btn btn-primary">
                <i class="fas fa-search"></i> Cari UMKM
            </a>
        </div>
    @endforelse
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
    <a href="{{ route('bookmarks.index') }}" class="active">
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
function toggleBookmark(companyId, button) {
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
            // Remove card from list
            button.closest('.card').remove();

            // Check if empty
            const cards = document.querySelectorAll('.card');
            if (cards.length === 1) { // Only header card left
                location.reload();
            }
        }
    })
    .catch(error => {
        alert('Gagal menghapus dari favorit');
    });
}
</script>
@endpush
