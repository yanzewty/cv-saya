@extends('portfolio.admin_layout')
@section('title', 'Kelola Panel Tambahan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <div>
        <h1 style="font-family: 'Sora', sans-serif; font-size: 28px; margin-bottom: 5px;">Panel Tambahan</h1>
        <p style="color: var(--dim); font-size: 14px;">Tambahkan kotak besar baru ke halaman depan sesuka hatimu.</p>
    </div>
    <a href="{{ route('portofolio.index') }}" target="_blank" style="padding: 10px 18px; border: 1px solid var(--line); border-radius: 10px; font-size: 13px; color: var(--text); text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
        <i class='bx bx-link-external'></i> Lihat Website
    </a>
</div>

@if (session('success_msg'))
<div style="background:rgba(46, 213, 115, 0.1); border:1px solid rgba(46, 213, 115, 0.3); color:#2ed573; padding: 14px 16px; border-radius: 12px; margin-bottom: 20px;">
    <i class='bx bx-check-circle'></i> {{ session('success_msg') }}
</div>
@endif

<!-- ============================================== -->
<!-- FORM TAMBAH KOTAK BARU -->
<!-- ============================================== -->
<div style="background: var(--panel); border: 1px solid var(--line); border-radius: 16px; padding: 30px; margin-bottom: 40px;">
    <h3 style="font-size: 16px; margin-bottom: 20px; color: var(--text); display: flex; align-items: center; gap: 8px;">
        <i class='bx bx-plus-circle' style="color: var(--cyan); font-size: 22px;"></i> Buat Kotak Panel Baru
    </h3>
    <form action="{{ route('admin.panels.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
            <div>
                <label style="font-size: 12px; font-weight: 600; color: var(--dim); text-transform: uppercase; margin-bottom: 8px; display: block;">Teks Tag (Kecil Kiri Atas)</label>
                <input type="text" name="tag" placeholder="Contoh: 01.5 / LAYANAN" required style="width: 100%; padding: 14px; background: var(--bg); border: 1px solid var(--line); border-radius: 10px; color: var(--text);">
            </div>
            <div>
                <label style="font-size: 12px; font-weight: 600; color: var(--dim); text-transform: uppercase; margin-bottom: 8px; display: block;">Judul Utama Kotak</label>
                <input type="text" name="title" placeholder="Contoh: Layanan Jasa Web" required style="width: 100%; padding: 14px; background: var(--bg); border: 1px solid var(--line); border-radius: 10px; color: var(--text);">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="font-size: 12px; font-weight: 600; color: var(--dim); text-transform: uppercase; margin-bottom: 8px; display: block;">Sub Kotak 1</label>
            <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                <input type="text" name="sub_1" placeholder="Judul Kecil 1" style="flex: 1; padding: 14px; background: var(--bg); border: 1px solid var(--line); border-radius: 10px; color: var(--text);">
                <input type="text" name="desc_1" placeholder="Deskripsi Kecil 1" style="flex: 2; padding: 14px; background: var(--bg); border: 1px solid var(--line); border-radius: 10px; color: var(--text);">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="font-size: 12px; font-weight: 600; color: var(--dim); text-transform: uppercase; margin-bottom: 8px; display: block;">Sub Kotak 2</label>
            <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                <input type="text" name="sub_2" placeholder="Judul Kecil 2" style="flex: 1; padding: 14px; background: var(--bg); border: 1px solid var(--line); border-radius: 10px; color: var(--text);">
                <input type="text" name="desc_2" placeholder="Deskripsi Kecil 2" style="flex: 2; padding: 14px; background: var(--bg); border: 1px solid var(--line); border-radius: 10px; color: var(--text);">
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="font-size: 12px; font-weight: 600; color: var(--dim); text-transform: uppercase; margin-bottom: 8px; display: block;">Sub Kotak 3</label>
            <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                <input type="text" name="sub_3" placeholder="Judul Kecil 3" style="flex: 1; padding: 14px; background: var(--bg); border: 1px solid var(--line); border-radius: 10px; color: var(--text);">
                <input type="text" name="desc_3" placeholder="Deskripsi Kecil 3" style="flex: 2; padding: 14px; background: var(--bg); border: 1px solid var(--line); border-radius: 10px; color: var(--text);">
            </div>
        </div>

        <button type="submit" style="width: 100%; padding: 16px; border: none; border-radius: 12px; cursor: pointer; background: var(--cyan); color: #fff; font-size: 14px; font-weight: 600; display: flex; justify-content: center; align-items: center; gap: 8px; transition: 0.2s;">
            <i class='bx bx-plus'></i> Tambahkan Kotak ke Website
        </button>
    </form>
</div>

<!-- ============================================== -->
<!-- LIST KOTAK YANG SUDAH DITAMBAHKAN (BISA DIHAPUS) -->
<!-- ============================================== -->
<div>
    <h3 style="font-size: 16px; margin-bottom: 20px; color: var(--text);">Daftar Kotak Tambahan di Website</h3>
    
    @if($panels->isEmpty())
        <p style="color: var(--dim); font-size: 14px; font-style: italic;">Belum ada kotak tambahan yang dibuat.</p>
    @endif

    @foreach($panels as $panel)
    <div style="background: var(--panel); border: 1px solid var(--line); border-radius: 16px; padding: 20px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <span style="font-size: 11px; color: var(--cyan); font-family: monospace; letter-spacing: 1px;">{{ $panel->tag }}</span>
            <h4 style="color: #fff; margin-top: 5px; font-size: 18px;">{{ $panel->title }}</h4>
        </div>
        <form action="{{ route('admin.panels.delete', $panel->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus Kotak ini dari halaman depan?');">
            @csrf
            @method('DELETE')
            <button type="submit" style="padding: 10px 16px; background: rgba(255, 93, 162, 0.1); color: var(--pink); border: 1px solid rgba(255, 93, 162, 0.3); border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-weight: 600;">
                <i class='bx bx-trash'></i> Hapus
            </button>
        </form>
    </div>
    @endforeach
</div>
@endsection