@extends('layouts.app')

@section('title', 'Kelola Produk - Temu')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-500/20 border border-green-500/30">
            <p class="text-green-100">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white/6 border border-white/10 p-6 rounded-xl">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold flex items-center gap-2 mb-1">
                    <svg class="w-6 h-6 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Produk Saya
                </h2>
                <p class="text-sm text-white/60">{{ $products->count() }} produk</p>
            </div>
            <a 
                href="{{ route('products.create') }}" 
                class="px-4 py-2 rounded-lg bg-brand-accent text-black font-medium hover:bg-brand-accent/90 transition flex items-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah
            </a>
        </div>
    </div>

    <!-- Products List -->
    <div class="space-y-4">
        @forelse($products as $product)
            <div class="bg-white/6 border border-white/10 p-4 rounded-xl">
                <div class="flex gap-3 mb-4">
                    @if($product->images->count() > 0)
                        <img 
                            src="{{ $product->images->first()->image_path }}" 
                            alt="Produk" 
                            class="w-20 h-20 rounded-lg object-cover flex-shrink-0"
                        >
                    @else
                        <div class="w-20 h-20 rounded-lg bg-white/5 flex items-center justify-center flex-shrink-0">
                            <svg class="w-10 h-10 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start gap-2 mb-2">
                            <h3 class="font-semibold text-base truncate">{{ $product->name }}</h3>
                            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0" id="toggle-{{ $product->id }}">
                                <input 
                                    type="checkbox" 
                                    {{ $product->is_active ? 'checked' : '' }} 
                                    onchange="toggleActive({{ $product->id }}, this)" 
                                    class="sr-only peer"
                                    id="checkbox-{{ $product->id }}"
                                >
                                <div class="w-11 h-6 bg-white/20 rounded-full peer peer-checked:bg-green-500 transition-colors relative">
                                    <div class="absolute top-[2px] left-[2px] bg-white rounded-full h-5 w-5 transition-transform peer-checked:translate-x-5"></div>
                                </div>
                            </label>
                        </div>
                        <p class="text-sm text-white/60 mb-2 line-clamp-2">{{ Str::limit($product->description, 50) }}</p>
                        <p class="text-lg font-bold text-green-400 mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-white/50">Stok: {{ $product->stock }}</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a 
                        href="{{ route('products.edit', $product->id) }}" 
                        class="flex-1 px-3 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium transition text-center flex items-center justify-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form 
                        action="{{ route('products.destroy', $product->id) }}" 
                        method="POST" 
                        class="flex-1"
                        onsubmit="return confirm('Yakin hapus produk ini?')"
                    >
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit" 
                            class="w-full px-3 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white text-sm font-medium transition flex items-center justify-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white/6 border border-white/10 p-12 rounded-xl text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/10 mb-4">
                    <svg class="w-8 h-8 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Belum Ada Produk</h3>
                <p class="text-white/60 text-sm mb-6">Tambahkan produk pertama Anda</p>
                <a 
                    href="{{ route('products.create') }}" 
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-brand-accent text-black font-semibold hover:bg-brand-accent/90 transition"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Produk
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleActive(productId, checkbox) {
    fetch(`/products/${productId}/toggle-active`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message);
        } else {
            checkbox.checked = !checkbox.checked;
        }
    })
    .catch(error => {
        alert('Gagal mengubah status produk');
        checkbox.checked = !checkbox.checked;
    });
}

function showToast(message) {
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.className = 'fixed top-20 left-1/2 transform -translate-x-1/2 bg-brand-accent text-black px-6 py-3 rounded-lg z-50 shadow-lg';
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s';
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}
</script>
@endpush

@push('scripts')
<script>
function toggleActive(productId, checkbox) {
    fetch(`/products/${productId}/toggle-active`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update toggle color
            const slider = checkbox.nextElementSibling;
            const knob = slider.nextElementSibling;

            if (data.is_active) {
                slider.style.background = '#10B981';
                knob.style.left = '27px';
            } else {
                slider.style.background = '#D1D5DB';
                knob.style.left = '3px';
            }

            showToast(data.message);
        }
    })
    .catch(error => {
        alert('Gagal mengubah status produk');
        checkbox.checked = !checkbox.checked;
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
@endpush
