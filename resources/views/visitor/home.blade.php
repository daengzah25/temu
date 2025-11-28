@extends('layouts.app')

@section('title', 'Home - Temu UMKM')

@section('content')
<div class="space-y-6">
  <!-- Hero Section -->
  <div class="text-center py-8">
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-surface/80 mb-4">
      <svg class="w-10 h-10 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
      </svg>
    </div>
    <h2 class="text-2xl font-bold mb-2 text-text">Temukan UMKM Terdekat</h2>
    <p class="text-muted mb-6">Cari dan hubungi UMKM di sekitar Anda</p>

    <a 
      href="{{ route('visitor.nearby') }}" 
      class="inline-flex items-center gap-2 px-6 py-3 rounded-lg2 bg-accent text-accent-contrast font-semibold hover:opacity-90 transition"
    >
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
      </svg>
      Cari UMKM Terdekat
    </a>
  </div>

  <!-- Search Bar -->
  @include('components.search-bar')

  <!-- Features -->
  <div class="bg-surface border border-border p-6 rounded-lg2">
    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2 text-text">
      <span class="text-accent">✨</span>
      Fitur Temu
    </h3>
    <div class="space-y-3 text-sm text-muted">
      <div class="flex items-start gap-3">
        <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        <span>Deteksi lokasi otomatis</span>
      </div>
      <div class="flex items-start gap-3">
        <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        <span>Ribuan UMKM terdaftar</span>
      </div>
      <div class="flex items-start gap-3">
        <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        <span>Hubungi langsung via WhatsApp</span>
      </div>
      <div class="flex items-start gap-3">
        <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
        <span>Simpan UMKM favorit</span>
      </div>
    </div>
  </div>

  @auth
    @if(Auth::user()->role === 'visitor')
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button 
          type="submit" 
          class="w-full px-4 py-3 rounded-lg2 bg-surface border border-border hover:bg-surface/80 transition text-center text-text"
        >
          <span class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            Keluar
          </span>
        </button>
      </form>
    @endif
  @endauth
</div>
@endsection
