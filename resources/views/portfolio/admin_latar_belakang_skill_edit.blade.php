@extends('portfolio.admin_layout')
@section('title', 'Edit Latar Belakang Skill')

@section('content')
<style>
  .edit-wrapper { max-width: 1000px; margin: 0 auto; padding-bottom: 60px; }
  
  .page-header { margin-bottom: 35px; }
  .page-title { font-family: 'Sora', sans-serif; font-size: 32px; font-weight: 800; color: #fff; margin-bottom: 8px; letter-spacing: -0.5px; }
  .page-desc { color: #8792A6; font-size: 14.5px; }

  /* SISTEM 2 KOLOM (GAMBAR DI KIRI, FORM DI KANAN) */
  .edit-grid { display: grid; grid-template-columns: 320px 1fr; gap: 30px; align-items: start; }
  @media (max-width: 768px) { .edit-grid { grid-template-columns: 1fr; } }

  /* KARTU KACA MINIMALIS */
  .glass-card {
      background: #10151F;
      border: 1px solid #232D3E;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.2);
  }

  .image-card { position: sticky; top: 100px; padding: 20px; }

  /* ==========================================
     AREA GAMBAR YANG PERFECT (NGGAK MENCENG)
     ========================================== */
  .upload-container {
      width: 100%;
      border-radius: 14px;
      overflow: hidden;
      background: #0A0E17;
      border: 2px dashed #232D3E;
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
  }
  .upload-container:hover { border-color: #4E9BE0; }
  
  .preview-wrapper {
      width: 100%;
      aspect-ratio: 16 / 9; /* Rasio gambar proporsional memanjang */
      background: #0A0E17;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
  }
  
  /* Ini rahasia biar gambarnya ngisi penuh dan nggak kecil! */
  .preview-wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover; 
  }
  
  .image-empty { color: #8792A6; font-size: 40px; }
  
  .upload-actions {
      padding: 20px 15px;
      text-align: center;
      background: #10151F;
      border-top: 1px solid #232D3E;
  }

  /* DESAIN TOMBOL CHOOSE FILE PREMIUM */
  input[type="file"] {
      color: #8792A6; font-family: 'Inter', sans-serif; font-size: 12px;
      outline: none; cursor: pointer; width: 100%;
  }
  input[type="file"]::file-selector-button {
      background: rgba(78, 155, 224, 0.1); border: 1px solid rgba(78, 155, 224, 0.3);
      color: #4E9BE0; padding: 8px 16px; border-radius: 8px;
      cursor: pointer; margin-right: 12px; font-family: 'Inter', sans-serif;
      font-weight: 600; transition: 0.3s;
  }
  input[type="file"]::file-selector-button:hover { background: #4E9BE0; color: #000; }

  /* FORM INPUTAN */
  .form-title { font-size: 16px; color: #fff; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; font-weight: 700; font-family: 'Sora', sans-serif; border-bottom: 1px solid #232D3E; padding-bottom: 15px; }
  .form-title i { color: #4E9BE0; font-size: 20px; }

  .form-label {
      display: block; color: #8792A6; font-size: 11.5px;
      text-transform: uppercase; letter-spacing: 1px;
      margin-bottom: 10px; font-weight: 600; font-family: 'Inter', sans-serif;
  }
  .form-control {
      width: 100%; background: #0A0E17; border: 1px solid #232D3E;
      color: #EAEEF5; padding: 15px 18px; border-radius: 12px;
      font-family: 'Inter', sans-serif; font-size: 14.5px; transition: 0.3s;
  }
  .form-control:focus {
      border-color: #4E9BE0; box-shadow: 0 0 0 4px rgba(78, 155, 224, 0.15); outline: none;
  }

  .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
  .mb-24 { margin-bottom: 24px; }

  /* ERROR ALERT */
  .error-list { background: rgba(255,59,48,0.08); border: 1px solid rgba(255,59,48,0.3); color: #ffb3ad; padding: 14px 18px; border-radius: 12px; font-size: 13px; margin-bottom: 24px; }
  .error-list ul { margin: 0; padding-left: 18px; }
  
  /* TOMBOL BAWAH */
  .btn-group { display: flex; gap: 15px; justify-content: flex-end; margin-top: 10px; border-top: 1px solid #232D3E; padding-top: 30px; }
  .btn-primary { background: linear-gradient(90deg, #3763E0, #4E9BE0); color: #fff; padding: 14px 28px; border-radius: 12px; border: none; font-weight: 600; cursor: pointer; transition: 0.3s; font-family: 'Inter', sans-serif; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;}
  .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(78, 155, 224, 0.3); }
  .btn-secondary { background: transparent; color: #8792A6; padding: 14px 28px; border-radius: 12px; border: 1px solid #232D3E; text-decoration: none; font-weight: 600; transition: 0.3s; font-family: 'Inter', sans-serif; font-size: 14px; display: inline-flex; align-items: center; }
  .btn-secondary:hover { border-color: #EAEEF5; color: #EAEEF5; }
</style>

<div class="edit-wrapper">
  <div class="page-header">
    <div class="page-title">Edit Detail Keahlian</div>
    <div class="page-desc">Perbarui data teks dan gambar untuk kartu modul keahlianmu.</div>
  </div>

  @if ($errors->any())
    <div class="error-list">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ url('/admin/latar-belakang-skill/' . $item->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="edit-grid">
      
      <!-- KOLOM KIRI: GAMBAR PRO (Ngisi Penuh Border) -->
      <div class="glass-card image-card">
        <div class="form-title"><i class='bx bx-image'></i> Gambar Ilustrasi</div>

        <div class="upload-container">
          <!-- Area Preview yang Pas 100% -->
          <div class="preview-wrapper">
            @if(!empty($item->gambar))
              <img src="{{ asset('uploads/'.$item->gambar) }}" alt="Preview" id="image-preview">
            @else
              <i class='bx bx-image image-empty' id="image-empty-icon"></i>
              <img src="" alt="Preview" id="image-preview" style="display:none;">
            @endif
          </div>

          <!-- Area Input File -->
          <div class="upload-actions">
            <input type="file" name="gambar" accept="image/*" onchange="previewEditImage(event)">
            <p style="color: #8792A6; font-size: 11px; margin-top: 12px; margin-bottom: 0;">*Biarkan kosong jika tidak diubah. Maks 2MB.</p>
          </div>
        </div>
      </div>

      <!-- KOLOM KANAN: FORM TEKS -->
      <div class="glass-card">
        <div class="form-title"><i class='bx bx-edit-alt'></i> Detail Teks Modul</div>

        <div class="grid-2">
          <div>
            <label class="form-label">Teks Modul</label>
            <input type="text" name="modul" value="{{ old('modul', $item->modul) }}" required class="form-control" placeholder="MODULE / 01">
          </div>
          <div>
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" value="{{ old('kategori', $item->kategori) }}" required class="form-control" placeholder="DEVELOPMENT">
          </div>
        </div>

        <div class="mb-24">
          <label class="form-label">Judul Keahlian</label>
          <input type="text" name="judul" value="{{ old('judul', $item->judul) }}" required class="form-control" style="font-weight: 600; font-size: 15px;">
        </div>

        <div style="margin-bottom: 0;">
          <label class="form-label">Deskripsi Lengkap</label>
          <textarea name="deskripsi" rows="6" required class="form-control" style="line-height: 1.6; resize: vertical;">{{ old('deskripsi', $item->deskripsi) }}</textarea>
        </div>

        <div class="btn-group">
          <a href="{{ route('admin.latar_belakang') }}" class="btn-secondary">Batal</a>
          <button type="submit" class="btn-primary">
            <i class='bx bx-save'></i> Simpan Perubahan
          </button>
        </div>
      </div>

    </div>
  </form>
</div>

<!-- Script bawaan untuk preview gambar langsung saat dipilih -->
<script>
  function previewEditImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function () {
      const img = document.getElementById('image-preview');
      img.src = reader.result;
      img.style.display = 'block';
      const emptyIcon = document.getElementById('image-empty-icon');
      if (emptyIcon) emptyIcon.style.display = 'none';
    };
    reader.readAsDataURL(file);
  }
</script>
@endsection