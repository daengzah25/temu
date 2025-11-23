@extends('layouts.app')

@section('title', 'Tambah Produk - Temu')

@section('content')
<div class="container">
    <div class="card">
        <a href="{{ route('products.index') }}" class="text-blue text-sm mb2" style="display: inline-block;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h2><i class="fas fa-plus-circle text-blue"></i> Tambah Produk Baru</h2>
    </div>

    @if($errors->any())
        <div class="card" style="background: #FEE2E2; border-left: 4px solid #EF4444;">
            @foreach($errors->all() as $error)
                <p style="color: #991B1B; font-size: 14px;" class="mb">• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card">
            <h3 class="mb2">Informasi Produk</h3>

            <label>Nama Produk *</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Kopi Arabika Premium" required>

            <label>Deskripsi</label>
            <textarea name="description" rows="3" placeholder="Ceritakan tentang produk Anda...">{{ old('description') }}</textarea>

            <label>Harga *</label>
            <input type="number" name="price" value="{{ old('price') }}" placeholder="50000" required min="0" step="100">

            <label>Stok *</label>
            <input type="number" name="stock" value="{{ old('stock') }}" placeholder="100" required min="0">
        </div>

        <div class="card">
            <h3 class="mb2">Foto Produk (Max 5 foto)</h3>
            <input type="file" name="images[]" accept="image/*" multiple onchange="previewImages(event)" id="imageInput">

            <div id="imagePreview" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 16px;"></div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-save"></i> Simpan Produk
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
            div.style.cssText = 'position: relative;';
            div.innerHTML = `
                <img src="${e.target.result}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
                <span style="position: absolute; top: 8px; right: 8px; background: #1F2937; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Foto ${index + 1}</span>
            `;
            preview.appendChild(div);
        }
        reader.readAsDataURL(file);
    });
}
</script>
@endpush
