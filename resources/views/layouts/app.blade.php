<!DOCTYPE html>
<html lang="id" class="dark antialiased">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="Platform Temu - Temukan UMKM Terdekat">
  <meta name="color-scheme" content="dark light">
  <title>@yield('title', 'Temu UMKM')</title>
  @php
    $manifestPath = public_path('build/manifest.json');
    $manifestExists = file_exists($manifestPath);
    
    if ($manifestExists) {
      $manifest = json_decode(file_get_contents($manifestPath), true);
      $cssFile = $manifest['resources/css/app.css']['file'] ?? 'assets/app-BcABIbwg.css';
      $jsFile = $manifest['resources/js/app.js']['file'] ?? 'assets/app-BWviUBFN.js';
    } else {
      $cssFile = 'assets/app-BcABIbwg.css';
      $jsFile = 'assets/app-BWviUBFN.js';
    }
  @endphp
  @if($manifestExists)
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @else
    {{-- Fallback jika manifest tidak ada atau Vite gagal --}}
    <link rel="stylesheet" href="{{ asset('build/' . $cssFile) }}">
    <script type="module" src="{{ asset('build/' . $jsFile) }}"></script>
  @endif
  @stack('styles')
</head>
<body class="bg-bg text-text min-h-screen">
  @include('components.header')

  <main class="max-w-3xl mx-auto px-4 sm:px-6 py-4 pb-28">
    @if(session('success'))
      <div class="mb-4 p-4 rounded-lg bg-green-500/10 dark:bg-green-500/20 border border-green-500/30">
        <p class="text-green-700 dark:text-green-100">{{ session('success') }}</p>
      </div>
    @endif

    @if(session('error'))
      <div class="mb-4 p-4 rounded-lg bg-red-500/10 dark:bg-red-500/20 border border-red-500/30">
        <p class="text-red-700 dark:text-red-100">{{ session('error') }}</p>
      </div>
    @endif

    @yield('content')
  </main>

  @include('components.mobile-nav')

  @stack('scripts')
</body>
</html>
