@extends('layouts.app')

@section('title', 'Kelola Produk - Temu')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-500/10 dark:bg-green-500/20 border border-green-500/30">
            <p class="text-green-700 dark:text-green-100">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-surface border border-border p-6 rounded-lg2">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold flex items-center gap-2 mb-1 text-text">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Produk Saya
                </h2>
                <p class="text-sm text-muted">{{ $products->count() }} produk</p>
            </div>
            <a 
                href="{{ route('products.create') }}" 
                class="px-4 py-2 rounded-lg2 bg-accent text-accent-contrast font-medium hover:opacity-90 transition flex items-center gap-2"
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
            <div class="bg-surface border border-border p-4 rounded-lg2">
                <div class="flex gap-3 mb-4">
                    @if($product->images->count() > 0)
                        <img 
                            src="{{ $product->images->first()->image_path }}" 
                            alt="Produk" 
                            class="w-20 h-20 rounded-lg object-cover flex-shrink-0"
                        >
                    @else
                        <div class="w-20 h-20 rounded-lg bg-surface/80 flex items-center justify-center flex-shrink-0">
                            <svg class="w-10 h-10 text-muted/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start gap-2 mb-2">
                            <h3 class="font-semibold text-base truncate text-text flex-1 min-w-0">{{ $product->name }}</h3>
                            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0" for="toggle-{{ $product->id }}">
                                <input 
                                    type="checkbox" 
                                    {{ $product->is_active ? 'checked' : '' }} 
                                    onchange="toggleActive({{ $product->id }}, this)" 
                                    class="sr-only peer"
                                    id="toggle-{{ $product->id }}"
                                >
                                <div class="relative w-11 h-6 rounded-full bg-surface/80 peer-checked:bg-green-500 transition-colors duration-200 ease-in-out">
                                    <span class="absolute top-[2px] left-[2px] w-5 h-5 bg-white rounded-full shadow-sm transition-transform duration-200 ease-in-out" id="knob-{{ $product->id }}" style="transform: translateX({{ $product->is_active ? '20px' : '0' }});"></span>
                                </div>
                            </label>
                        </div>
                        <p class="text-sm text-muted mb-2 line-clamp-2">{{ Str::limit($product->description, 50) }}</p>
                        <p class="text-lg font-bold text-green-400 mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-muted">Stok: {{ $product->stock }}</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a 
                        href="{{ route('products.edit', $product->id) }}" 
                        class="flex-1 px-3 py-2 rounded-lg2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium transition text-center flex items-center justify-center gap-2"
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
                            class="w-full px-3 py-2 rounded-lg2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium transition flex items-center justify-center gap-2"
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
            <div class="bg-surface border border-border p-12 rounded-lg2 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-surface/80 mb-4">
                    <svg class="w-8 h-8 text-muted/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-text">Belum Ada Produk</h3>
                <p class="text-muted text-sm mb-6">Tambahkan produk pertama Anda</p>
                <a 
                    href="{{ route('products.create') }}" 
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-lg2 bg-accent text-accent-contrast font-semibold hover:opacity-90 transition"
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
    // Update knob position immediately for visual feedback
    const knob = document.getElementById(`knob-${productId}`);
    const slider = checkbox.nextElementSibling;
    
    if (checkbox.checked) {
        knob.style.transform = 'translateX(20px)';
        slider.classList.remove('bg-surface/80');
        slider.classList.add('bg-green-500');
    } else {
        knob.style.transform = 'translateX(0)';
        slider.classList.remove('bg-green-500');
        slider.classList.add('bg-surface/80');
    }
    
    // Disable checkbox during request
    checkbox.disabled = true;
    
    fetch(`/products/${productId}/toggle-active`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast(data.message || 'Status produk berhasil diubah');
        } else {
            // Revert checkbox state and visual if failed
            checkbox.checked = !checkbox.checked;
            if (checkbox.checked) {
                knob.style.transform = 'translateX(20px)';
                slider.classList.remove('bg-surface/80');
                slider.classList.add('bg-green-500');
            } else {
                knob.style.transform = 'translateX(0)';
                slider.classList.remove('bg-green-500');
                slider.classList.add('bg-surface/80');
            }
            showToast(data.message || 'Gagal mengubah status produk', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert checkbox state and visual on error
        checkbox.checked = !checkbox.checked;
        if (checkbox.checked) {
            knob.style.transform = 'translateX(20px)';
            slider.classList.remove('bg-surface/80');
            slider.classList.add('bg-green-500');
        } else {
            knob.style.transform = 'translateX(0)';
            slider.classList.remove('bg-green-500');
            slider.classList.add('bg-surface/80');
        }
        showToast('Gagal mengubah status produk. Silakan coba lagi.', 'error');
    })
    .finally(() => {
        // Re-enable checkbox
        checkbox.disabled = false;
    });
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.textContent = message;
    const bgColor = type === 'error' ? 'bg-red-500' : 'bg-accent';
    const textColor = type === 'error' ? 'text-white' : 'text-accent-contrast';
    toast.className = `fixed top-20 left-1/2 transform -translate-x-1/2 ${bgColor} ${textColor} px-6 py-3 rounded-lg z-50 shadow-lg font-medium`;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s';
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}
</script>
@endpush






