<header class="sticky top-0 z-40 bg-bg/95 backdrop-blur border-b border-border py-4">
  <div class="max-w-screen-sm mx-auto px-4 flex items-center justify-between">
    <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition">
      {{-- Logo dengan switching untuk dark/light mode --}}
      <div class="dark:hidden">
        <img src="{{ asset('images/lightlogo.png') }}" alt="Logo Temu UMKM" class="h-12 w-12 object-contain" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2240%22 fill=%22%23fff%22/%3E%3Ctext x=%2250%22 y=%2265%22 font-size=%2240%22 text-anchor=%22middle%22 fill=%22%23000%22%3ET%3C/text%3E%3C/svg%3E'">
      </div>
      <div class="hidden dark:block">
        <img src="{{ asset('images/darklogo.png') }}" alt="Logo Temu UMKM" class="h-12 w-12 object-contain" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2240%22 fill=%22%23fff%22/%3E%3Ctext x=%2250%22 y=%2265%22 font-size=%2240%22 text-anchor=%22middle%22 fill=%22%23000%22%3ET%3C/text%3E%3C/svg%3E'">
      </div>
    </a>

    <div class="flex items-center gap-3">
      {{-- Theme Toggle Button --}}
      <button id="themeToggle" class="text-sm px-3 py-1.5 rounded-lg border border-border hover:bg-surface transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent" aria-label="Toggle theme">
        <span class="dark:hidden">🌙 Dark</span>
        <span class="hidden dark:inline">☀️ Light</span>
      </button>

      {{-- Desktop Navigation --}}
      <div class="hidden md:block">
        @auth
          @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg2 bg-accent text-accent-contrast font-semibold hover:opacity-90 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent">Dashboard</a>
          @elseif(Auth::user()->role === 'umkm')
            <a href="{{ route('umkm.dashboard') }}" class="px-4 py-2 rounded-lg2 bg-accent text-accent-contrast font-semibold hover:opacity-90 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent">Dashboard</a>
          @else
            <a href="{{ route('visitor.home') }}" class="px-4 py-2 rounded-lg2 bg-accent text-accent-contrast font-semibold hover:opacity-90 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent">Beranda</a>
          @endif
        @else
          <a href="{{ route('auth.google') }}" class="px-4 py-2 rounded-lg2 bg-accent text-accent-contrast font-semibold hover:opacity-90 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent">Masuk</a>
        @endauth
      </div>
    </div>
  </div>
</header>

