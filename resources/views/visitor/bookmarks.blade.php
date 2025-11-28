@extends('layouts.app')

@section('title', 'Favorit Saya - Temu UMKM')

@section('content')
<div class="space-y-4">
  <!-- Header -->
  <div class="flex items-center justify-between">
    <div>
      <h2 class="text-xl font-bold flex items-center gap-2 text-text">
        <svg class="w-6 h-6 text-red-400" fill="currentColor" viewBox="0 0 24 24">
          <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
        Favorit Saya
      </h2>
      <p class="text-sm text-muted mt-1">{{ $bookmarks->count() }} UMKM tersimpan</p>
    </div>
  </div>

  <!-- Bookmarks List -->
  <div class="space-y-4">
    @forelse($bookmarks as $bookmark)
      @php $company = $bookmark->company; @endphp
      <div class="bg-surface border border-border p-4 rounded-lg2">
        <div class="flex gap-3 mb-3">
          @if($company->logo)
            <img 
              src="{{ $company->logo }}" 
              alt="{{ $company->name }}" 
              class="w-20 h-20 rounded-lg object-cover flex-shrink-0"
              loading="lazy"
            >
          @else
            <div class="w-20 h-20 rounded-lg bg-surface/80 flex items-center justify-center flex-shrink-0">
              <svg class="w-10 h-10 text-muted/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
              </svg>
            </div>
          @endif

          <div class="flex-1 min-w-0">
            <h3 class="font-semibold text-base mb-1 truncate text-text">{{ $company->name }}</h3>
            <p class="text-sm text-muted mb-1">
              <span class="inline-block px-2 py-0.5 bg-surface/80 rounded text-xs">{{ $company->category }}</span>
            </p>
            <p class="text-xs text-muted line-clamp-1">
              {{ \Illuminate\Support\Str::limit($company->address, 40) }}
            </p>
          </div>
        </div>

        <div class="flex gap-2">
          <a 
            href="{{ route('visitor.company.show', $company->slug) }}" 
            class="flex-1 px-3 py-2 rounded-lg bg-accent text-black text-sm font-medium hover:bg-accent/90 transition text-center"
          >
            Detail
          </a>
          <a 
            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}" 
            target="_blank" 
            class="flex-1 px-3 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-text text-sm font-medium transition text-center"
          >
            WhatsApp
          </a>
          <button 
            onclick="toggleBookmark({{ $company->id }}, this)" 
            class="px-3 py-2 rounded-lg bg-red-500/20 border border-red-500/50 text-red-400 hover:bg-red-500/30 transition"
            title="Hapus dari Favorit"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
          </button>
        </div>
      </div>
    @empty
      <div class="text-center py-12">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-surface/80 mb-4">
          <svg class="w-8 h-8 text-muted/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
          </svg>
        </div>
          <h3 class="text-lg font-semibold mb-2 text-text">Belum Ada Favorit</h3>
        <p class="text-muted text-sm mb-6">Simpan UMKM favorit Anda untuk akses cepat</p>
        <a 
          href="{{ route('visitor.nearby') }}" 
          class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-accent text-black font-semibold hover:bg-accent/90 transition"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
          Cari UMKM
        </a>
      </div>
    @endforelse
  </div>
</div>
@endsection

@push('scripts')
<script>
function toggleBookmark(companyId, button) {
  const card = button.closest('.bg-surface');
  
  fetch(`/bookmark/${companyId}/toggle`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Animate removal
      card.style.opacity = '0';
      card.style.transform = 'translateX(-20px)';
      card.style.transition = 'all 0.3s';
      
      setTimeout(() => {
        card.remove();
        
        // Check if empty and reload if needed
        const remainingCards = document.querySelectorAll('.bg-surface');
        if (remainingCards.length === 0) {
          setTimeout(() => location.reload(), 300);
        }
      }, 300);
      
      showToast(data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showToast('Gagal menghapus dari favorit');
  });
}

function showToast(message) {
  const toast = document.createElement('div');
  toast.textContent = message;
  toast.className = 'fixed top-20 left-1/2 transform -translate-x-1/2 bg-accent text-accent-contrast px-6 py-3 rounded-lg z-50 shadow-lg';
  document.body.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transition = 'opacity 0.3s';
    setTimeout(() => toast.remove(), 300);
  }, 2000);
}
</script>
@endpush
