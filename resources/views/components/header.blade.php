<header class="py-4 flex items-center justify-between border-b border-white/10">
  <div class="flex items-center gap-3">
    <img src="/images/2.png" alt="Logo Temu UMKM" class="h-12 w-12 object-contain" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2240%22 fill=%22%23fff%22/%3E%3Ctext x=%2250%22 y=%2265%22 font-size=%2240%22 text-anchor=%22middle%22 fill=%22%23000%22%3ET%3C/text%3E%3C/svg%3E'">
    <div>
      <h1 class="text-lg font-semibold">Temu UMKM</h1>
      <p class="text-xs text-white/60">Temukan UMKM terdekat di sekitar Anda</p>
    </div>
  </div>

  <div class="hidden md:block">
    @auth
      @if(Auth::user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-brand-accent text-black font-medium hover:bg-brand-accent/90 transition">Dashboard</a>
      @elseif(Auth::user()->role === 'umkm')
        <a href="{{ route('umkm.dashboard') }}" class="px-4 py-2 rounded-lg bg-brand-accent text-black font-medium hover:bg-brand-accent/90 transition">Dashboard</a>
      @else
        <a href="{{ route('visitor.home') }}" class="px-4 py-2 rounded-lg bg-brand-accent text-black font-medium hover:bg-brand-accent/90 transition">Beranda</a>
      @endif
    @else
      <a href="{{ route('auth.google') }}" class="px-4 py-2 rounded-lg bg-brand-accent text-black font-medium hover:bg-brand-accent/90 transition">Masuk</a>
    @endauth
  </div>
</header>

