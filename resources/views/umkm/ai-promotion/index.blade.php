@extends('layouts.app')

@section('title', 'AI Promosi - Temu')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="card" style="background: #D1FAE5; border-left: 4px solid #10B981;">
            <p style="color: #065F46;">{{ session('success') }}</p>
        </div>
    @endif

    <div class="card">
        <h2><i class="fas fa-robot text-blue"></i> AI Promosi Otomatis</h2>
        <p class="text-sm text-gray">Generate konten promosi untuk produk Anda</p>
    </div>

    <form id="aiForm">
        @csrf
        <div class="card">
            <h3 class="mb2">Informasi Produk</h3>

            <label>Pilih Produk (Opsional)</label>
            <select name="product_id" id="productSelect" onchange="fillProduct(this)">
                <option value="">-- Atau isi manual --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->price }}"
                            data-description="{{ $product->description }}">
                        {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>

            <label>Nama Produk *</label>
            <input type="text" name="product_name" id="productName" placeholder="Contoh: Kopi Arabika Premium" required>

            <label>Harga *</label>
            <input type="text" name="price" id="productPrice" placeholder="50000" required>

            <label>Deskripsi/Keunggulan *</label>
            <textarea name="description" id="productDescription" rows="3" placeholder="Contoh: Kopi pilihan terbaik dari pegunungan, rasa smooth, tanpa kafein berlebih" required></textarea>

            <label>Target Audience *</label>
            <input type="text" name="target_audience" placeholder="Contoh: Anak muda 20-35 tahun, pekerja kantoran" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block" id="generateBtn">
            <i class="fas fa-magic"></i> Generate Konten AI
        </button>
    </form>

    <!-- Loading State -->
    <div id="loadingState" style="display: none;">
        <div class="card text-center">
            <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #3B82F6; margin-bottom: 16px;"></i>
            <h3>AI sedang membuat konten...</h3>
            <p class="text-sm text-gray">Tunggu 5-10 detik</p>
        </div>
    </div>

    <!-- Result -->
    <div id="resultContainer" style="display: none;"></div>

    <!-- History -->
    @if($promotions->count() > 0)
        <div class="card">
            <h3 class="mb2">📋 History ({{ $promotions->count() }})</h3>

            @foreach($promotions as $promo)
                <div class="card" style="background: #F9FAFB; margin-bottom: 12px;">
                    <div class="flex justify-between items-center mb">
                        <span style="background: #3B82F6; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                            {{ strtoupper($promo->platform) }}
                        </span>
                        <span class="text-sm text-gray">{{ $promo->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm" style="white-space: pre-wrap;">{{ Str::limit($promo->result, 100) }}</p>
                    <div class="flex gap mt2">
                        <button onclick="copyText(`{{ addslashes($promo->result) }}`)" class="btn" style="flex: 1; background: #10B981; color: white; padding: 8px; font-size: 14px;">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                        <form action="{{ route('ai-promotion.destroy', $promo->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Hapus promosi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="width: 100%; background: #EF4444; color: white; padding: 8px; font-size: 14px;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('bottom-nav')
<nav class="bottom-nav">
    <a href="{{ route('umkm.dashboard') }}">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('products.index') }}">
        <i class="fas fa-box"></i>
        <span>Produk</span>
    </a>
    <a href="{{ route('ai-promotion.index') }}" class="active">
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
// Fill form dari dropdown produk
function fillProduct(select) {
    const option = select.options[select.selectedIndex];
    if (option.value) {
        document.getElementById('productName').value = option.dataset.name;
        document.getElementById('productPrice').value = option.dataset.price;
        document.getElementById('productDescription').value = option.dataset.description;
    }
}

// Submit form AI
document.getElementById('aiForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData);

    // Show loading
    document.getElementById('generateBtn').disabled = true;
    document.getElementById('generateBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
    document.getElementById('loadingState').style.display = 'block';
    document.getElementById('resultContainer').style.display = 'none';

    try {
        const response = await fetch('{{ route("ai-promotion.generate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            displayResults(result.data, data);
        } else {
            alert('Error: ' + result.error);
        }

    } catch (error) {
        alert('Gagal generate konten: ' + error.message);
    } finally {
        document.getElementById('generateBtn').disabled = false;
        document.getElementById('generateBtn').innerHTML = '<i class="fas fa-magic"></i> Generate Konten AI';
        document.getElementById('loadingState').style.display = 'none';
    }
});

// Display hasil AI
function displayResults(data, formData) {
    const container = document.getElementById('resultContainer');

    container.innerHTML = `
        <div class="card">
            <h3 class="mb2">✅ Konten Siap Digunakan!</h3>

            <div class="card" style="background: #DBEAFE; margin-bottom: 12px;">
                <div class="flex justify-between items-center mb">
                    <h3><i class="fab fa-instagram"></i> Instagram Caption</h3>
                    <button onclick="copyText(\`${escapeHtml(data.instagram)}\`)" class="btn" style="background: #3B82F6; color: white; padding: 6px 12px; font-size: 12px;">
                        <i class="fas fa-copy"></i> Salin
                    </button>
                </div>
                <p class="text-sm" style="white-space: pre-wrap;">${escapeHtml(data.instagram)}</p>
                <button onclick="savePromotion('instagram', '${escapeHtml(JSON.stringify(formData))}', \`${escapeHtml(data.instagram)}\`)" class="btn btn-block mt2" style="background: #10B981; color: white;">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>

            <div class="card" style="background: #D1FAE5; margin-bottom: 12px;">
                <div class="flex justify-between items-center mb">
                    <h3><i class="fab fa-whatsapp"></i> WhatsApp Broadcast</h3>
                    <button onclick="copyText(\`${escapeHtml(data.whatsapp)}\`)" class="btn" style="background: #10B981; color: white; padding: 6px 12px; font-size: 12px;">
                        <i class="fas fa-copy"></i> Salin
                    </button>
                </div>
                <p class="text-sm" style="white-space: pre-wrap;">${escapeHtml(data.whatsapp)}</p>
                <button onclick="savePromotion('whatsapp', '${escapeHtml(JSON.stringify(formData))}', \`${escapeHtml(data.whatsapp)}\`)" class="btn btn-block mt2" style="background: #10B981; color: white;">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>

            <div class="card" style="background: #E0E7FF;">
                <div class="flex justify-between items-center mb">
                    <h3><i class="fab fa-facebook"></i> Facebook Post</h3>
                    <button onclick="copyText(\`${escapeHtml(data.facebook)}\`)" class="btn" style="background: #3B5998; color: white; padding: 6px 12px; font-size: 12px;">
                        <i class="fas fa-copy"></i> Salin
                    </button>
                </div>
                <p class="text-sm" style="white-space: pre-wrap;">${escapeHtml(data.facebook)}</p>
                <button onclick="savePromotion('facebook', '${escapeHtml(JSON.stringify(formData))}', \`${escapeHtml(data.facebook)}\`)" class="btn btn-block mt2" style="background: #10B981; color: white;">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
    `;

    container.style.display = 'block';
    container.scrollIntoView({ behavior: 'smooth' });
}

// Copy to clipboard
function copyText(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('Teks berhasil disalin!');
    });
}

// Save promotion
async function savePromotion(platform, promptData, result) {
    const data = JSON.parse(promptData);

    try {
        const response = await fetch('{{ route("ai-promotion.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: data.product_id || null,
                platform: platform,
                prompt: JSON.stringify(data),
                result: result
            })
        });

        const res = await response.json();

        if (res.success) {
            showToast('Konten berhasil disimpan!');
            setTimeout(() => location.reload(), 1500);
        }

    } catch (error) {
        alert('Gagal menyimpan: ' + error.message);
    }
}

// Escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}

// Toast notification
function showToast(message) {
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.style.cssText = 'position: fixed; top: 80px; left: 50%; transform: translateX(-50%); background: #1F2937; color: white; padding: 12px 24px; border-radius: 8px; z-index: 9999;';
    document.body.appendChild(toast);

    setTimeout(() => toast.remove(), 2000);
}
</script>
@endpush
