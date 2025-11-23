@extends('layouts.app')

@section('title', 'Pilih Role - Temu')

@section('content')
<div class="container">
    <div class="card text-center">
        <img src="{{ Auth::user()->avatar }}" alt="Avatar" style="width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 16px;">
        <h2>Halo, {{ Auth::user()->name }}!</h2>
        <p class="text-gray mb3">Anda ingin menggunakan Temu sebagai:</p>
    </div>
    
    <form action="{{ route('role.update') }}" method="POST">
        @csrf
        
        <div class="card" style="cursor: pointer; border: 2px solid transparent;" onclick="selectRole('umkm', this)">
            <div class="flex items-center gap">
                <div style="min-width: 60px; text-align: center;">
                    <i class="fas fa-store" style="font-size: 48px; color: #3B82F6;"></i>
                </div>
                <div style="flex: 1;">
                    <h3>Pemilik UMKM</h3>
                    <p class="text-sm text-gray">Daftarkan usaha, kelola produk, dan gunakan AI untuk promosi</p>
                </div>
                <input type="radio" name="role" value="umkm" style="width: 24px; height: 24px; margin: 0;">
            </div>
        </div>
        
        <div class="card" style="cursor: pointer; border: 2px solid transparent;" onclick="selectRole('visitor', this)">
            <div class="flex items-center gap">
                <div style="min-width: 60px; text-align: center;">
                    <i class="fas fa-search" style="font-size: 48px; color: #10B981;"></i>
                </div>
                <div style="flex: 1;">
                    <h3>Pengunjung</h3>
                    <p class="text-sm text-gray">Cari UMKM terdekat, simpan favorit, dan hubungi via WhatsApp</p>
                </div>
                <input type="radio" name="role" value="visitor" style="width: 24px; height: 24px; margin: 0;">
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary btn-block" id="submitBtn" disabled style="background: #D1D5DB; cursor: not-allowed;">Lanjutkan</button>
    </form>
</div>

<script>
function selectRole(role, element) {
    document.querySelectorAll('.card').forEach(card => {
        card.style.border = '2px solid transparent';
    });
    element.style.border = '2px solid #3B82F6';
    element.querySelector('input[type="radio"]').checked = true;
    var btn = document.getElementById('submitBtn');
    btn.disabled = false;
    btn.style.background = '#3B82F6';
    btn.style.cursor = 'pointer';
}
</script>
@endsection
