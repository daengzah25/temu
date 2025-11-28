@extends('layouts.app')

@section('title', 'AI Promosi - Temu')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-500/10 dark:bg-green-500/20 border border-green-500/30">
            <p class="text-green-700 dark:text-green-100">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-surface border border-border p-6 rounded-lg2">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-text">AI Promosi Otomatis</h2>
                <p class="text-sm text-muted">Generate konten promosi untuk produk Anda</p>
            </div>
        </div>
    </div>

    <form id="aiForm" class="space-y-6">
        @csrf
        <div class="bg-surface border border-border p-6 rounded-lg2 space-y-4">
            <h3 class="font-semibold text-lg mb-4 text-text">Informasi Produk</h3>

            <div>
                <label class="block text-sm font-medium text-text mb-2">Pilih Produk (Opsional)</label>
                <select name="product_id" id="productSelect" onchange="fillProduct(this)" class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border text-text placeholder:text-muted/60 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent [&>option]:bg-brand-dark [&>option]:text-text">
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
            </div>

            <div>
                <label class="block text-sm font-medium text-text mb-2">Nama Produk *</label>
                <input type="text" name="product_name" id="productName" placeholder="Contoh: Kopi Arabika Premium" required class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border text-text placeholder:text-muted/60 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-text mb-2">Harga *</label>
                <input type="text" name="price" id="productPrice" placeholder="50000" required class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border text-text placeholder:text-muted/60 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-text mb-2">Deskripsi/Keunggulan *</label>
                <textarea name="description" id="productDescription" rows="3" placeholder="Contoh: Kopi pilihan terbaik dari pegunungan, rasa smooth, tanpa kafein berlebih" required class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border text-text placeholder:text-muted/60 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent resize-none"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-text mb-2">Target Audience *</label>
                <input type="text" name="target_audience" placeholder="Contoh: Anak muda 20-35 tahun, pekerja kantoran" required class="w-full px-4 py-3 rounded-lg bg-surface/80 border border-border text-text placeholder:text-muted/60 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
            </div>
        </div>

        <button type="submit" class="w-full px-6 py-4 rounded-lg bg-accent text-accent-contrast font-semibold hover:bg-accent/90 transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed" id="generateBtn" aria-label="Generate konten AI untuk promosi">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
            </svg>
            <span>Generate Konten AI</span>
        </button>
    </form>

    <!-- Loading State -->
    <div id="loadingState" style="display: none;">
        <div class="bg-surface border border-border p-12 rounded-lg2 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-500/20 mb-4">
                <svg class="w-8 h-8 text-green-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2 text-text">AI sedang membuat konten...</h3>
            <p class="text-sm text-muted">Tunggu 5-10 detik</p>
        </div>
    </div>

    <!-- Result -->
    <div id="resultContainer" style="display: none;"></div>

    <!-- History -->
    @if($promotions->count() > 0)
        <div class="bg-surface border border-border p-6 rounded-lg2">
            <h3 class="font-semibold text-lg mb-4 flex items-center gap-2 text-text">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                History ({{ $promotions->count() }})
            </h3>

            <div class="space-y-3">
                @foreach($promotions as $promo)
                    <div class="bg-surface/80 border border-border p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-3">
                            <span class="px-3 py-1 rounded-full bg-blue-500/20 text-blue-400 text-xs font-semibold">
                                {{ strtoupper($promo->platform) }}
                            </span>
                            <span class="text-sm text-muted">{{ $promo->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-muted mb-4 whitespace-pre-wrap line-clamp-3">{{ Str::limit($promo->result, 100) }}</p>
                        <div class="flex gap-2">
                            <button onclick="copyText(`{{ addslashes($promo->result) }}`)" class="flex-1 px-3 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-text text-sm font-medium transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Salin
                            </button>
                            <form action="{{ route('ai-promotion.destroy', $promo->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus promosi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-3 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-text text-sm font-medium transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
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
    const generateBtn = document.getElementById('generateBtn');
    generateBtn.disabled = true;
    generateBtn.innerHTML = `
        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
        Generating...
    `;
    document.getElementById('loadingState').style.display = 'block';
    document.getElementById('resultContainer').style.display = 'none';

    try {
        // Tambah timeout 90 detik
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 90000);

        const response = await fetch('{{ route("ai-promotion.generate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data),
            signal: controller.signal
        });

        clearTimeout(timeoutId);

        // Check if response is ok
        if (!response.ok) {
            let errorMessage = `Server error: ${response.status} ${response.statusText}`;
            const contentType = response.headers.get('content-type');
            
            try {
                if (contentType && contentType.includes('application/json')) {
                    const errorData = await response.json();
                    errorMessage = errorData.error || errorData.message || errorMessage;
                } else {
                    // If not JSON, try to get text
                    const errorText = await response.text();
                    if (errorText && errorText.trim()) {
                        errorMessage = `Error ${response.status}: ${errorText.substring(0, 200)}`;
                    }
                }
            } catch (e) {
                // Keep default error message if parsing fails
                console.error('Error parsing response:', e);
            }
            throw new Error(errorMessage);
        }

        // Validate response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Server returned non-JSON response');
        }

        const result = await response.json();

        if (result.success) {
            displayResults(result.data, data);
        } else {
            showToast('Error: ' + result.error, 'error');
        }

    } catch (error) {
        if (error.name === 'AbortError') {
            showToast('Request timeout. Model mungkin masih loading, coba lagi dalam 20 detik.', 'error');
        } else if (error.message.includes('Failed to fetch') || error.message.includes('NetworkError')) {
            showToast('Gagal terhubung ke server. Periksa koneksi internet Anda atau coba lagi nanti.', 'error');
        } else {
            showToast('Gagal generate konten: ' + error.message, 'error');
        }
    } finally {
        generateBtn.disabled = false;
        generateBtn.innerHTML = `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
            </svg>
            Generate Konten AI
        `;
        document.getElementById('loadingState').style.display = 'none';
    }
});

// Display hasil AI
function displayResults(data, formData) {
    const container = document.getElementById('resultContainer');

    container.innerHTML = `
        <div class="bg-surface border border-border p-6 rounded-lg2 space-y-4">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-10 h-10 rounded-lg bg-green-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-text">Konten Siap Digunakan!</h3>
            </div>

            <div class="bg-blue-500/10 border border-blue-500/20 p-4 rounded-lg">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold flex items-center gap-2 text-text">
                        <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        Instagram Caption
                    </h3>
                    <button onclick="copyText(\`${escapeHtml(data.instagram)}\`)" class="px-3 py-1.5 rounded-lg bg-blue-500 hover:bg-blue-600 text-text text-xs font-medium transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Salin
                    </button>
                </div>
                <p class="text-sm text-muted whitespace-pre-wrap mb-3">${escapeHtml(data.instagram)}</p>
                <button onclick="savePromotion('instagram', '${escapeHtml(JSON.stringify(formData))}', \`${escapeHtml(data.instagram)}\`)" class="w-full px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-text text-sm font-medium transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan
                </button>
            </div>

            <div class="bg-green-500/10 border border-green-500/20 p-4 rounded-lg">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold flex items-center gap-2 text-text">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.372a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        WhatsApp Broadcast
                    </h3>
                    <button onclick="copyText(\`${escapeHtml(data.whatsapp)}\`)" class="px-3 py-1.5 rounded-lg bg-green-500 hover:bg-green-600 text-text text-xs font-medium transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Salin
                    </button>
                </div>
                <p class="text-sm text-muted whitespace-pre-wrap mb-3">${escapeHtml(data.whatsapp)}</p>
                <button onclick="savePromotion('whatsapp', '${escapeHtml(JSON.stringify(formData))}', \`${escapeHtml(data.whatsapp)}\`)" class="w-full px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-text text-sm font-medium transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan
                </button>
            </div>

            <div class="bg-blue-500/10 border border-blue-500/20 p-4 rounded-lg">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold flex items-center gap-2 text-text">
                        <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook Post
                    </h3>
                    <button onclick="copyText(\`${escapeHtml(data.facebook)}\`)" class="px-3 py-1.5 rounded-lg bg-blue-500 hover:bg-blue-600 text-text text-xs font-medium transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Salin
                    </button>
                </div>
                <p class="text-sm text-muted whitespace-pre-wrap mb-3">${escapeHtml(data.facebook)}</p>
                <button onclick="savePromotion('facebook', '${escapeHtml(JSON.stringify(formData))}', \`${escapeHtml(data.facebook)}\`)" class="w-full px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-text text-sm font-medium transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan
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
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: data.product_id || null,
                platform: platform,
                prompt: JSON.stringify(data),
                result: result
            })
        });

        // Check if response is ok
        if (!response.ok) {
            let errorMessage = `Server error: ${response.status} ${response.statusText}`;
            const contentType = response.headers.get('content-type');
            
            try {
                if (contentType && contentType.includes('application/json')) {
                    const errorData = await response.json();
                    errorMessage = errorData.error || errorData.message || errorMessage;
                } else {
                    // If not JSON, try to get text
                    const errorText = await response.text();
                    if (errorText && errorText.trim()) {
                        errorMessage = `Error ${response.status}: ${errorText.substring(0, 200)}`;
                    }
                }
            } catch (e) {
                // Keep default error message if parsing fails
                console.error('Error parsing response:', e);
            }
            throw new Error(errorMessage);
        }

        // Validate response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Server returned non-JSON response');
        }

        const res = await response.json();

        if (res.success) {
            showToast('Konten berhasil disimpan!', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('Gagal menyimpan konten', 'error');
        }

    } catch (error) {
        if (error.message.includes('Failed to fetch') || error.message.includes('NetworkError')) {
            showToast('Gagal terhubung ke server. Periksa koneksi internet Anda atau coba lagi nanti.', 'error');
        } else {
            showToast('Gagal menyimpan: ' + error.message, 'error');
        }
    }
}

// Escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}

// Toast notification
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
