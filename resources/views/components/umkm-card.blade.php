<article class="bg-white/6 border border-white/10 p-4 rounded-xl shadow-sm flex gap-3 hover:bg-white/8 transition">
  @if($umkm->logo)
    <img 
      src="{{ $umkm->logo }}" 
      alt="{{ $umkm->name }}" 
      class="w-20 h-20 rounded-lg object-cover flex-shrink-0" 
      loading="lazy"
    >
  @else
    <div class="w-20 h-20 rounded-lg bg-white/5 flex items-center justify-center flex-shrink-0">
      <svg class="w-10 h-10 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
      </svg>
    </div>
  @endif

  <div class="flex-1 min-w-0">
    <h3 class="font-semibold text-base mb-1 truncate">{{ $umkm->name }}</h3>
    <p class="text-sm text-white/60 mt-1 line-clamp-2">{{ \Illuminate\Support\Str::limit($umkm->description ?? $umkm->category, 60) }}</p>
    <div class="mt-2 flex items-center justify-between flex-wrap gap-2">
      <div class="flex items-center gap-2 flex-wrap">
        <span class="inline-block px-2 py-1 bg-white/8 rounded text-xs">{{ $umkm->category }}</span>
        @if(isset($umkm->distance_km))
          <span class="text-xs text-white/60 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            {{ number_format($umkm->distance_km, 1) }} km
          </span>
        @endif
      </div>
      <a 
        href="{{ route('visitor.company.show', $umkm->slug) }}" 
        class="px-3 py-1.5 rounded bg-brand-accent text-black text-sm font-medium hover:bg-brand-accent/90 transition whitespace-nowrap"
      >
        Detail
      </a>
    </div>
  </div>
</article>

