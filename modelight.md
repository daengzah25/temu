siap, dafong. berikut **tech spec light mode** (dark tetap default) + setup Tailwind v4 biar warna aksen tetap “nendang” di background putih (tidak nyaru). semua contoh siap tempel ke Laravel + Blade.

# Tujuan

* Default: **dark mode** (sesuai logo).
* Tersedia **light mode** dengan aksen yang kontras pada putih.
* Satu sumber kebenaran via **CSS variables** + Tailwind tokens (mudah ganti tema tanpa ubah komponen).
* Logo untuk mode light public/images/1.png

---

# Palet Warna (semantic tokens)

## Dark (default)

* `bg` #0B0B0B
* `surface` #111111
* `text` #F8F7F7
* `muted` #9CA3AF
* `border` #232323
* `accent` **#FF7A00** (electric orange — kontras tinggi, konsisten di light)
* `accent-contrast` #0B0B0B (teks di atas accent)
* `accent-soft` #381F0B (badge/hover subtle)

## Light

* `bg` #FAFAFA
* `surface` #FFFFFF
* `text` #0B0B0B
* `muted` #4B5563
* `border` #E5E7EB
* `accent` **#FF7A00** (tetap “non-nyaru” di putih)
* `accent-contrast` #0B0B0B
* `accent-soft` #FFF3E8

> Kenapa #FF7A00? Di light, oranye ini **tidak menyatu** dengan putih; di dark tetap “pop”. Kalau nanti ingin nuansa hijau, tinggal ganti `--accent`.

---

# Tailwind v4 config (pakai CSS variables)

`tailwind.config.js`

```js
/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class', // kita kontrol via class .dark
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        // gunakan format rgb(var(--token) / <alpha-value>) agar bisa transparansi
        bg: 'rgb(var(--bg) / <alpha-value>)',
        surface: 'rgb(var(--surface) / <alpha-value>)',
        text: 'rgb(var(--text) / <alpha-value>)',
        muted: 'rgb(var(--muted) / <alpha-value>)',
        border: 'rgb(var(--border) / <alpha-value>)',
        accent: 'rgb(var(--accent) / <alpha-value>)',
        'accent-contrast': 'rgb(var(--accent-contrast) / <alpha-value>)',
        'accent-soft': 'rgb(var(--accent-soft) / <alpha-value>)',
      },
      borderRadius: { 'lg2': '1rem' },
      boxShadow: { soft: '0 6px 18px rgba(0,0,0,0.45)' },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        display: ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
```

`resources/css/app.css`

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

/* LIGHT defaults */
:root {
  --bg: 250 250 250;
  --surface: 255 255 255;
  --text: 11 11 11;
  --muted: 75 85 99;
  --border: 229 231 235;
  --accent: 255 122 0;
  --accent-contrast: 11 11 11;
  --accent-soft: 255 243 232;
}

/* DARK overrides (default mode via .dark on <html>) */
.dark {
  --bg: 11 11 11;
  --surface: 17 17 17;
  --text: 248 247 247;
  --muted: 156 163 175;
  --border: 35 35 35;
  --accent: 255 122 0;
  --accent-contrast: 11 11 11;
  --accent-soft: 56 31 11;
}
```

---

# Default ke Dark + Toggle Mode

**Layout Blade (`resources/views/layouts/app.blade.php`)**

```blade
<!DOCTYPE html>
<html lang="id" class="dark"> {{-- default dark --}}
  <head>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <meta name="color-scheme" content="dark light">
  </head>
  <body class="bg-bg text-text">
    <header class="sticky top-0 z-40 bg-bg/95 backdrop-blur border-b border-border">
      <div class="max-w-screen-sm mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="w-9 h-9">
          <span class="font-display text-base">TEM UMKM</span>
        </div>
        <button id="themeToggle" class="text-sm px-3 py-1 rounded-lg border border-border hover:bg-surface">
          <span class="dark:hidden">🌙 Dark</span>
          <span class="hidden dark:inline">☀️ Light</span>
        </button>
      </div>
    </header>

    <main class="min-h-dvh">
      {{ $slot ?? '' }}
    </main>
  </body>
</html>
```

**JS minimal (`resources/js/app.js`)**

```js
// persist preferensi
const root = document.documentElement;
const saved = localStorage.getItem('theme');
if (saved === 'light') root.classList.remove('dark');
if (saved === 'dark') root.classList.add('dark');

const btn = document.getElementById('themeToggle');
btn?.addEventListener('click', () => {
  const isDark = root.classList.toggle('dark');
  localStorage.setItem('theme', isDark ? 'dark' : 'light');
});
```

---

# Pola Komponen (warna “nendang” di light)

**Primary Button (CTA)**

```blade
<button class="inline-flex items-center justify-center px-4 py-2 rounded-lg2
               bg-accent text-accent-contrast font-semibold
               hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent
               active:scale-[.99] transition">
  Daftarkan UMKM
</button>
```

> Di light, `bg-accent` oranye akan sangat kontras di `bg` putih. Di dark, tetap menyala.

**Secondary Button**

```blade
<button class="px-4 py-2 rounded-lg2 border border-border bg-surface text-text hover:bg-surface/80">
  Lihat
</button>
```

**Card**

```blade
<div class="bg-surface border border-border rounded-lg2 p-3 shadow-soft">
  <h3 class="text-base font-semibold">Nama UMKM</h3>
  <p class="text-sm text-muted mt-1">Kategori • 1.2 km</p>
  <div class="mt-3 flex items-center justify-between">
    <span class="text-sm text-muted">Kontak: <a class="text-accent font-medium" href="#">0812…</a></span>
    <a class="px-3 py-1 rounded-full border border-border" href="#">Detail</a>
  </div>
</div>
```

**Badge & Chip (gunakan accent-soft agar tidak nyaru di putih)**

```blade
<span class="px-2 py-1 rounded-full text-xs bg-accent-soft text-text/80 border border-border">Terdekat</span>
```

---

# Aksesibilitas & Kontras

* Aksen #FF7A00 di atas putih/gelap punya kontras > 4.5:1 (tekstual oke).
* Pastikan ikon-only punya `aria-label`.
* `focus-visible:ring-2 ring-accent` untuk navigasi keyboard.

---

# Logo di Light Mode

* Logo Anda ber-outline putih → di light **outline bisa “hilang”**.

  * Solusi cepat: tampilkan logo di **capsule gelap**:
    `class="p-1 rounded-xl bg-text"` lalu `<img class="invert">` jika perlu.
  * Atau pakai **drop-shadow**: `class="drop-shadow-[0_0_0.75rem_rgba(0,0,0,0.4)]"`.
  * Lebih ideal: sediakan **varian light** (outline lebih gelap).

---

# QA Checklist

* Default render: `<html class="dark">`.
* Toggle menyimpan preferensi di `localStorage`.
* Cek kontras tombol accent pada halaman putih (light).
* Uji di width 320/375/414/768.
* Cek state: hover/focus/disabled terlihat di dua mode.

---

kalau kamu mau, aku bisa **convert satu halaman Blade** kamu (home/list UMKM) ke skema dua-mode ini, lengkap dengan kelas-kelasnya, tanpa nyentuh logic backend.
