@extends('portfolio.admin_layout')
@section('title', 'Edit Section Latar Belakang')

@section('content')
<style>
  /* ========================================= */
  /* UI KHUSUS UNTUK HALAMAN EDIT (FOCUS MODE) */
  /* ========================================= */
  .wrap-form { max-width: 850px; margin: 0 auto; }

  /* BREADCRUMB & HEADER */
  .edit-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; }
  .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--dim); margin-bottom: 12px; font-weight: 500; }
  .breadcrumb a { color: var(--cyan); text-decoration: none; transition: 0.2s; display: inline-flex; align-items: center; gap: 4px; }
  .breadcrumb a:hover { color: #fff; }
  .badge-edit { background: rgba(255, 171, 0, 0.15); color: #ffab00; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; letter-spacing: 1px; display: inline-flex; align-items: center; gap: 5px; border: 1px solid rgba(255, 171, 0, 0.3); text-transform: uppercase; }

  /* EDITOR CARD */
  .editor-card { background: var(--panel); border: 1px solid var(--line); border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.3); transition: 0.3s; }
  .editor-card:hover { border-color: rgba(255, 171, 0, 0.3); box-shadow: 0 20px 40px rgba(255, 171, 0, 0.05); }
  
  .editor-header-bar { background: rgba(255, 255, 255, 0.02); border-bottom: 1px solid var(--line); padding: 20px 30px; display: flex; align-items: center; gap: 12px; }
  .editor-header-bar i { font-size: 24px; color: #ffab00; }
  .editor-header-bar h3 { font-size: 16px; font-weight: 600; color: #fff; margin: 0; font-family: 'Sora', sans-serif; }
  
  .editor-body { padding: 30px; }

  /* FORM INPUTS DENGAN ICON */
  .form-group { margin-bottom: 24px; }
  label { font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--dim); display: flex; align-items: center; gap: 6px; margin-bottom: 10px; }
  
  .input-wrapper { position: relative; }
  .input-wrapper i { position: absolute; left: 16px; top: 15px; color: var(--dim); font-size: 18px; pointer-events: none; transition: 0.2s; }
  
  input[type=text], textarea { width: 100%; background: var(--bg); border: 1px solid var(--line); border-radius: 10px; color: var(--text); font-size: 14px; transition: all 0.2s; font-family: 'Inter', sans-serif; }
  input[type=text] { padding: 14px 16px 14px 45px; } /* Space for icon */
  textarea { padding: 14px 16px; }
  
  /* Efek Glow Warna Kuning/Emas Khas Mode Edit */
  input[type=text]:focus, textarea:focus { outline: none; border-color: #ffab00; box-shadow: 0 0 0 3px rgba(255, 171, 0, 0.15); }
  input[type=text]:focus + i, textarea:focus + i, .input-wrapper input:focus ~ i { color: #ffab00; }
  
  .help-text { font-size: 11px; color: var(--dim); margin-top: 8px; font-style: italic; display: block; }

  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
  @media (max-width: 600px) { .grid2 { grid-template-columns: 1fr; } }

  /* FOOTER & BUTTONS */
  .editor-footer { padding: 24px 30px; background: rgba(0,0,0,0.15); border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 15px; align-items: center; }
  
  .btn-cancel { padding: 14px 24px; border-radius: 12px; font-size: 14px; font-weight: 600; color: var(--text); background: transparent; border: 1px solid var(--line); cursor: pointer; transition: 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
  .btn-cancel:hover { background: rgba(255,255,255,0.05); border-color: var(--dim); color: #fff; }

  .btn-save { padding: 14px 30px; border-radius: 12px; font-size: 14px; font-weight: 700; color: #000; background: #ffab00; border: none; cursor: pointer; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(255, 171, 0, 0.25); }
  .btn-save:hover { background: #ffc400; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(255, 171, 0, 0.4); }
</style>

<div class="wrap-form">
  
  <!-- BREADCRUMB & HEADER -->
  <div class="edit-header">
    <div>
      <div class="breadcrumb">
        <a href="{{ route('admin.about') }}"><i class='bx bx-arrow-back'></i> Kelola Tentang Saya</a> 
        <span>/</span> 
        <span style="color: var(--text);">Edit Section</span>
      </div>
      <h1 style="font-family: 'Sora', sans-serif; font-size: 32px; margin-bottom: 0; color: #fff;">Ubah Konten</h1>
    </div>
    
    <!-- BADGE KHUSUS MODE EDIT -->
    <div class="badge-edit">
      <i class='bx bx-pulse' style="animation: bx-flashing 2s infinite linear;"></i> Mode Edit Aktif
    </div>
  </div>

  <form action="{{ route('admin.panels.update', $panel->id) }}" method="POST">
    @csrf
    
    <div class="editor-card">
      <!-- HEADER CARD -->
      <div class="editor-header-bar">
        <i class='bx bx-slider-alt'></i>
        <h3>Properti Latar Belakang #{{ $panel->id }}</h3>
      </div>

      <!-- BODY CARD -->
      <div class="editor-body">
        <div class="grid2 form-group">
          <div>
            <label>Tag Kecil Atas</label>
            <div class="input-wrapper">
              <input type="text" name="tag" value="{{ $panel->tag }}" required>
              <i class='bx bx-purchase-tag'></i>
            </div>
            <span class="help-text">Teks kecil berwarna biru di atas judul.</span>
          </div>
          
          <div>
            <label>Judul Utama (Kiri)</label>
            <div class="input-wrapper">
              <input type="text" name="title" value="{{ $panel->title }}" required>
              <i class='bx bx-heading'></i>
            </div>
            <span class="help-text">Judul besar yang menjadi sorotan utama.</span>
          </div>
        </div>

        <div class="form-group" style="margin-bottom: 0;">
          <label><i class='bx bx-text'></i> Deskripsi Panjang (Kanan)</label>
          <div class="input-wrapper">
            <!-- Textarea sengaja gak dikasih icon padding kiri biar leluasa ngetik -->
            <textarea name="desc_1" rows="7" required style="line-height: 1.7;">{{ $panel->desc_1 }}</textarea>
          </div>
          <span class="help-text">Gunakan Enter untuk membuat paragraf baru.</span>
        </div>
      </div>

      <!-- FOOTER CARD (ACTION BUTTONS) -->
      <div class="editor-footer">
        <a href="{{ route('admin.about') }}" class="btn-cancel">
          <i class='bx bx-x'></i> Batal
        </a>
        <button type="submit" class="btn-save">
          <i class='bx bx-check-double' style="font-size: 18px;"></i> Terapkan Perubahan
        </button>
      </div>

    </div>
  </form>
</div>
@endsection