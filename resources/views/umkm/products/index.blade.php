@extends('layouts.app')

@section('title', 'Kelola Produk - Temu')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="card" style="background: #D1FAE5; border-left: 4px solid #10B981;">
            <p style="color: #065F46;">{{ session('success') }}</p>
        </div>
    @endif

    <div class="card">
        <div class="flex justify-between items-center">
            <div>
                <h2><i class="fas fa-box"></i> Produk Saya</h2>
                <p class="text-sm text-gray">{{ $products->count() }} produk</p>
            </div>
            <a href="{{ route('products.create') }}" class="btn" style="background: #10B981; color: white; text-decoration: none;">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
    </div>

    @forelse($products as $product)
        <div class="card" style="margin-bottom: 16px;">
            <div class="flex gap">
                @if($product->images->count() > 0)
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="Produk" style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px;">
                @else
                    <div style="width: 80px; height: 80px; background: #E5E7EB; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-image" style="font-size: 32px; color: #6B7280;"></i>
                    </div>
                @endif

                <div style="flex: 1;">
                    <div class="flex justify-between items-center">
                        <h3>{{ $product->name }}</h3>
                        <label style="position: relative; display: inline-block; width: 48px; height: 24px;">
                            <input type="checkbox" {{ $product->is_active ? 'checked' : '' }} onchange="toggleActive({{ $product->id }}, this)" style="opacity: 0; width: 0; height: 0;">
                            <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: {{ $product->is_active ? '#10B981' : '#D1D5DB' }}; border-radius: 24px; transition: 0.3s;"></span>
                            <span style="position: absolute; content: ''; height: 18px; width: 18px; left: {{ $product->is_active ? '27px' : '3px' }}; bottom: 3px; background: white; border-radius: 50%; transition: 0.3s;"></span>
                        </label>
                    </div>
                    <p class="text-sm text-gray mb">{{ Str::limit($product->description, 50) }}</p>
                    <p style="font-size: 18px; font-weight: 700; color: #10B981;">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray">Stok: {{ $product->stock }}</p>
                </div>
            </div>

            <div class="flex gap mt2">
                <a href="{{ route('products.edit', $product->id) }}" class="btn" style="flex: 1; background: #3B82F6; color: white; text-decoration: none; padding: 10px; text-align: center;">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Yakin hapus produk ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="width: 100%; background: #EF4444; color: white; padding: 10px;">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="card text-center">
            <i class="fas fa-box-open" style="font-size: 64px; color: #D1D5DB; margin-bottom: 16px;"></i>
            <h3>Belum Ada Produk</h3>
            <p class="text-gray mb3">Tambahkan produk pertama Anda</p>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>
    @endforelse
</div>
@endsection

@section('bottom-nav')
<nav class="bottom-nav">
    <a href="{{ route('umkm.dashboard') }}">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('products.index') }}" class="active">
        <i class="fas fa-box"></i>
        <span>Produk</span>
    </a>
    <a href="{{ route('ai-promotion.index') }}">
        <i class="fas fa-robot"></i>
        <span>AI Promosi</span>
    </a>
    <a href="{{ route('profile.show') }}">
        <i class="fas fa-user"></i>
        <span>Profil</span>
    </a>
</nav>
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
