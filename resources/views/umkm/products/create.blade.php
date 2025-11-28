@extends('layouts.app')

@section('title', 'Tambah Produk - Temu')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-surface border border-border p-6 rounded-lg2">
        <a 
            href="{{ route('products.index') }}" 
            class="inline-flex items-center gap-2 text-sm text-muted hover:text-text transition mb-4"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
        <h2 class="text-xl font-bold flex items-center gap-2 text-text">
            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Produk Baru
        </h2>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-lg bg-red-500/10 dark:bg-red-500/20 border border-red-500/30">
            @foreach($errors->all() as $error)
                <p class="text-red-700 dark:text-red-100 text-sm mb-1">• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Product Information -->
        <div class="bg-surface border border-border p-6 rounded-lg2">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2 text-text">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Informasi Produk
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-text mb-2">Nama Produk *</label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="Contoh: Kopi Arabika Premium" 
                        required
                        class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border text-text placeholder:text-muted/60 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-text mb-2">Deskripsi</label>
                    <textarea 
                        name="description" 
                        rows="3" 
                        placeholder="Ceritakan tentang produk Anda..."
                        class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border text-text placeholder:text-muted/60 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent resize-none"
                    >{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-text mb-2">Harga *</label>
                        <input 
                            type="number" 
                            name="price" 
                            value="{{ old('price') }}" 
                            placeholder="50000" 
                            required 
                            min="0" 
                            step="100"
                            class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border text-text placeholder:text-muted/60 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text mb-2">Stok *</label>
                        <input 
                            type="number" 
                            name="stock" 
                            value="{{ old('stock') }}" 
                            placeholder="100" 
                            required 
                            min="0"
                            class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border text-text placeholder:text-muted/60 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Images -->
        <div class="bg-surface border border-border p-6 rounded-lg2">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2 text-text">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Foto Produk (Max 5 foto)
            </h3>
            
            <label class="block">
                <input 
                    type="file" 
                    name="images[]" 
                    accept="image/*" 
                    multiple 
                    onchange="previewImages(event)" 
                    id="imageInput"
                    class="block w-full text-sm text-muted file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-accent file:text-accent-contrast hover:file:opacity-90 cursor-pointer"
                >
            </label>

            <div id="imagePreview" class="grid grid-cols-2 gap-4 mt-4"></div>
        </div>

        <button 
            type="submit" 
            class="w-full px-4 py-3 rounded-lg2 bg-accent text-accent-contrast font-semibold hover:opacity-90 transition flex items-center justify-center gap-2"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Simpan Produk
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewImages(event) {
    const files = event.target.files;
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    if (files.length > 5) {
        alert('Maksimal 5 foto');
        document.getElementById('imageInput').value = '';
        return;
    }

    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-40 object-cover rounded-lg">
                <span class="absolute top-2 right-2 bg-black/60 text-text px-2 py-1 rounded text-xs">Foto ${index + 1}</span>
            `;
            preview.appendChild(div);
        }
        reader.readAsDataURL(file);
    });
}
</script>
@endpush
