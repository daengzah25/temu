@extends('layouts.app')

@section('title', 'Edit Produk - Temu')

@section('content')
<div class="container">
    <div class="card">
        <a href="{{ route('products.index') }}" class="text-blue text-sm mb2" style="display: inline-block;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h2><i class="fas fa-edit text-blue"></i> Edit Produk</h2>
    </div>

    @if($errors->any())
        <div class="card" style="background: #FEE2E2; border-left: 4px solid #EF4444;">
            @foreach($errors->all() as $error)
                <p style="color: #991B1B; font-size: 14px;" class="mb">• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card">
            <h3 class="mb2">Informasi Produk</h3>

            <label>Nama Produk *</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required>

            <label>Deskripsi</label>
            <textarea name="description" rows="3">{{ old('description', $product->description) }}</textarea>

            <label>Harga *</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" step="100">

            <label>Stok *</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
        </div>

        @if($product->images->count() > 0)
            <div class="card">
                <h3 class="mb2">Foto Saat Ini</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    @foreach($product->images as $image)
                        <div style="position: relative;" id="image-{{ $image->id }}">
                            <img src="{{$image->image_path) }}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
                            <button type="button" onclick="deleteImage({{ $image->id }})" style="position: absolute; top: 8px; right: 8px; background: #EF4444; color: white; border: none; padding: 6px 10px; border-radius: 6px; cursor: pointer;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="card">
            <h3 class="mb2">Tambah Foto Baru</h3>
            <input type="file" name="images[]" accept="image/*" multiple onchange="previewImages(event)" id="imageInput">
            <div id="imagePreview" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 16px;"></div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-save"></i> Update Produk
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

    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">`;
            preview.appendChild(div);
        }
        reader.readAsDataURL(file);
    });
}

function deleteImage(imageId) {
    if (!confirm('Yakin hapus foto ini?')) return;

    fetch(`/products/image/${imageId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`image-${imageId}`).remove();
        }
    })
    .catch(error => alert('Gagal menghapus foto'));
}
</script>
@endpush
