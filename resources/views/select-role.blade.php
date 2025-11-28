@extends('layouts.app')

@section('title', 'Pilih Role - Temu')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-surface border border-border p-6 rounded-lg2 text-center">
        <div class="inline-flex items-center justify-center mb-4">
            <img 
                src="{{ Auth::user()->avatar }}" 
                alt="Avatar" 
                class="w-20 h-20 rounded-full border-4 border-accent object-cover"
            >
        </div>
        <h2 class="text-xl font-bold mb-2 text-text">Halo, {{ Auth::user()->name }}!</h2>
        <p class="text-sm text-muted">Anda ingin menggunakan Temu sebagai:</p>
    </div>
    
    <form action="{{ route('role.update') }}" method="POST">
        @csrf
        
        <!-- UMKM Option -->
        <div 
            class="role-card bg-white/6 border-2 border-transparent p-6 rounded-lg2 cursor-pointer hover:bg-surface/80 transition-all"
            onclick="selectRole('umkm', this)"
            data-role="umkm"
        >
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-16 h-16 bg-blue-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-lg mb-1 text-text">Pemilik UMKM</h3>
                    <p class="text-sm text-muted">Daftarkan usaha, kelola produk, dan gunakan AI untuk promosi</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="w-6 h-6 rounded-full border-2 border-border flex items-center justify-center">
                        <div class="w-3 h-3 rounded-full bg-accent hidden"></div>
                    </div>
                </div>
                <input type="radio" name="role" value="umkm" class="hidden">
            </div>
        </div>
        
        <!-- Visitor Option -->
        <div 
            class="role-card bg-white/6 border-2 border-transparent p-6 rounded-lg2 cursor-pointer hover:bg-surface/80 transition-all"
            onclick="selectRole('visitor', this)"
            data-role="visitor"
        >
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-16 h-16 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-lg mb-1 text-text">Pengunjung</h3>
                    <p class="text-sm text-muted">Cari UMKM terdekat, simpan favorit, dan hubungi via WhatsApp</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="w-6 h-6 rounded-full border-2 border-border flex items-center justify-center">
                        <div class="w-3 h-3 rounded-full bg-accent hidden"></div>
                    </div>
                </div>
                <input type="radio" name="role" value="visitor" class="hidden">
            </div>
        </div>
        
        <button 
            type="submit" 
            id="submitBtn" 
            disabled 
            class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border text-muted/60 cursor-not-allowed transition font-medium"
        >
            Lanjutkan
        </button>
    </form>
</div>

@push('scripts')
<script>
function selectRole(role, element) {
    // Reset all cards
    document.querySelectorAll('.role-card').forEach(card => {
        card.classList.remove('border-accent', 'bg-surface/80');
        card.classList.add('border-transparent');
        
        // Hide radio indicator
        const indicator = card.querySelector('.w-3');
        if (indicator) {
            indicator.classList.add('hidden');
        }
        
        // Uncheck radio
        const radio = card.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = false;
        }
    });
    
    // Select current card
    element.classList.remove('border-transparent');
    element.classList.add('border-accent', 'bg-surface/80');
    
    // Show radio indicator
    const indicator = element.querySelector('.w-3');
    if (indicator) {
        indicator.classList.remove('hidden');
    }
    
    // Check radio
    const radio = element.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }
    
    // Enable submit button
    const btn = document.getElementById('submitBtn');
    if (btn) {
        btn.disabled = false;
        btn.classList.remove('bg-surface/80', 'border-border', 'text-muted/60', 'cursor-not-allowed');
        btn.classList.add('bg-accent', 'text-accent-contrast', 'hover:opacity-90', 'cursor-pointer');
    }
}
</script>
@endpush
@endsection
