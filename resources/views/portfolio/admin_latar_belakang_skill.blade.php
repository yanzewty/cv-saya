@extends('portfolio.admin_layout')
@section('title', 'Kelola Latar Belakang Skill')

@section('content')
<style>
  .wrap-form { max-width: 1100px; margin: 0 auto; animation: fadeIn 0.5s ease; padding-bottom: 60px; }
  @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

  .header-flex { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 35px; position: relative; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); }
  .header-flex h1 { font-family: 'Sora', sans-serif; font-size: 32px; font-weight: 800; margin-bottom: 6px; color: #fff; letter-spacing: -0.5px; }
  .header-flex p { color: #8792A6; font-size: 14px; }
  .btn-outline { padding: 12px 20px; border: 1px solid #232D3E; border-radius: 12px; font-size: 13px; color: #EAEEF5; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s; background: rgba(10,14,23,0.5); font-weight: 600; }
  .btn-outline:hover { border-color: #4E9BE0; color: #fff; background: rgba(78, 155, 224, 0.1); transform: translateY(-2px); }
  
  .alert-succ { background: rgba(52,199,123,0.1); border-left: 4px solid #34C77B; color: #34C77B; padding: 16px 20px; border-radius: 12px; font-size: 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 30px; font-weight: 600; backdrop-filter: blur(5px); }

  /* KARTU GLASSMORPHISM */
  .glass-card { background: rgba(16, 21, 31, 0.6); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 24px; padding: 35px; box-shadow: 0 20px 40px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.1); margin-bottom: 40px; }

  /* FORM KECIL */
  .form-title { font-size: 18px; color: #fff; margin-bottom: 28px; display: flex; align-items: center; gap: 12px; font-weight: 700; font-family: 'Sora', sans-serif; }
  .form-title .icon-wrap { background: rgba(78, 155, 224, 0.1); width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border-radius: 10px; color: #4E9BE0; font-size: 20px; }
  .form-group-new { margin-bottom: 24px; position: relative; }
  .form-label-new { display: block; color: #8792A6; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 10px; font-weight: 600; font-family: 'Inter', sans-serif; }
  .form-control-new { width: 100%; background: rgba(10, 14, 23, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); color: #EAEEF5; padding: 16px 20px; border-radius: 14px; font-family: 'Inter', sans-serif; font-size: 14px; transition: all 0.3s; }
  .form-control-new:focus { background: rgba(10, 14, 23, 0.8); border-color: #4E9BE0; box-shadow: 0 0 0 4px rgba(78, 155, 224, 0.1); outline: none; transform: translateY(-2px); }
  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
  .submit-btn-glow { background: linear-gradient(135deg, #3763E0, #4E9BE0); color: #fff; padding: 14px 32px; border-radius: 14px; border: none; font-weight: 600; font-family: 'Inter', sans-serif; font-size: 14px; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 8px 20px rgba(55, 99, 224, 0.3); }
  .submit-btn-glow:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(55, 99, 224, 0.5); }

  /* DATA EXISTING GRID */
  .skill-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 26px; margin-top: 18px; margin-bottom: 50px; }
  .card-item { background: #10151F; border: 1px solid #232D3E; border-radius: 20px; overflow: hidden; position: relative; transition: 0.3s; display: flex; flex-direction: column; box-shadow: 0 15px 35px rgba(0,0,0,0.2); }
  .card-item:hover { transform: translateY(-6px); border-color: rgba(78, 155, 224, 0.4); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
  .card-image-wrap { position: relative; width: 100%; aspect-ratio: 16/9; overflow: hidden; background: #0A0E17; }
  .card-image-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
  .card-item:hover .card-image-wrap img { transform: scale(1.05); }
  .card-image-wrap::after { content: ""; position: absolute; inset: 0; background: linear-gradient(0deg, rgba(16,21,31,0.95), transparent 60%); pointer-events: none; }
  .card-content { padding: 0 24px 24px; flex: 1; display: flex; flex-direction: column; position: relative; z-index: 2; margin-top: -20px; }
  .card-module { font-family: 'JetBrains Mono', monospace; font-size: 10.5px; color: #8792A6; letter-spacing: 1px; margin-bottom: 8px; }
  .card-title { font-size: 18px; color: #fff; font-weight: 700; margin-bottom: 12px; font-family: 'Sora', sans-serif; line-height: 1.3; }
  .card-desc { font-size: 13px; color: #8792A6; line-height: 1.6; margin-bottom: 18px; flex-grow: 1; }
  .card-footer { margin-top: auto; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #232D3E; padding-top: 16px; }
  .card-cat { font-family: 'JetBrains Mono', monospace; font-size: 10.5px; color: #C9A24A; font-weight: 600; text-transform: uppercase; }
  .card-detail { font-size: 11.5px; color: #8792A6; transition: 0.2s; text-decoration: none; }
  
  /* ACTION BUTTONS */
  .action-buttons-float { position: absolute; top: 14px; right: 14px; display: flex; gap: 8px; z-index: 10; opacity: 0; transition: 0.3s; transform: translateY(-10px); }
  .card-item:hover .action-buttons-float { opacity: 1; transform: translateY(0); }
  .btn-float { width: 36px; height: 36px; border-radius: 10px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #fff; text-decoration: none; backdrop-filter: blur(6px); transition: 0.2s; box-shadow: 0 4px 15px rgba(0,0,0,0.3); }
  .btn-float-edit { background: rgba(78, 155, 224, 0.85); border: 1px solid rgba(78, 155, 224, 0.4); }
  .btn-float-edit:hover { background: #4E9BE0; transform: scale(1.1); }
  .btn-float-delete { background: rgba(224, 78, 92, 0.85); border: 1px solid rgba(224, 78, 92, 0.4); }
  .btn-float-delete:hover { background: #E04E5C; transform: scale(1.1); }

  /* ==========================================
     RE-DESIGN: TATA LETAK 2 KOLOM (KIRI GAMBAR, KANAN FORM)
     ========================================== */
  .add-new-layout {
      display: grid;
      grid-template-columns: 360px 1fr; /* Kolom kiri lebih lebar agar pas */
      gap: 35px;
      align-items: stretch; /* Form dan gambar sejajar tingginya */
  }
  @media (max-width: 900px) { .add-new-layout { grid-template-columns: 1fr; } }

  .upload-pro-container {
      width: 100%;
      height: 100%; /* Memenuhi tinggi kolom kiri */
      min-height: 380px; /* Jaga tinggi minimal */
      border: 2px dashed rgba(78, 155, 224, 0.4);
      border-radius: 18px;
      background: rgba(10, 14, 23, 0.5);
      position: relative;
      overflow: hidden; /* INI KUNCI AGAR GAMBAR TIDAK MELUBER */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s ease;
  }
  .upload-pro-container:hover { border-color: #4E9BE0; background: rgba(78, 155, 224, 0.1); }

  /* RAHASIA GAMBAR PENUH 100% MENUTUPI KOTAK */
  .upload-pro-container img {
      position: absolute; /* Lepas dari flow, tumpuk di atas segalanya */
      inset: 0;           /* Tempel ke 4 sisi batas kotak */
      width: 100%;        /* Lebar penuh */
      height: 100%;       /* Tinggi penuh */
      object-fit: cover;  /* Tidak gepeng, terpotong rapi pinggirannya */
      z-index: 10;        /* Pastikan di atas teks placeholder */
      display: none;      /* Sembunyikan jika kosong */
  }

  .upload-placeholder {
      position: relative;
      z-index: 2;
      text-align: center;
      color: #8792A6;
      padding: 20px;
  }
  .upload-pro-container:hover .upload-placeholder { color: #4E9BE0; }
  .upload-placeholder i { font-size: 50px; margin-bottom: 15px; opacity: 0.9; }
  .upload-placeholder p { font-size: 15px; font-weight: 700; margin: 0; font-family: 'Sora', sans-serif; }
  .upload-placeholder span { font-size: 12px; opacity: 0.6; margin-top: 8px; display: block; }
</style>

<div class="wrap-form">
  <div class="header-flex">
    <div>
      <h1>Latar Belakang Skill</h1>
      <p>Kelola gambar dan data modul keahlian yang akan tampil di halaman portofolio utama.</p>
    </div>
    <a href="{{ route('portofolio.index') }}#LatarBelakangSkill" target="_blank" class="btn-outline">
      <i class='bx bx-link-external'></i> Lihat Website
    </a>
  </div>

  @if (session('success_msg'))
    <div class="alert-succ"><i class='bx bx-check-shield' style="font-size: 20px;"></i> <span>{{ session('success_msg') }}</span></div>
  @endif

  <!-- FORM 1: HEADER UTAMA -->
  <form action="{{ route('admin.latar_belakang.header') }}" method="POST">
    @csrf
    <div class="glass-card">
      <div class="form-title">
        <div class="icon-wrap"><i class='bx bx-edit-alt'></i></div>
        Teks Header Utama
      </div>

      <div class="grid2 form-group-new">
        <div>
          <label class="form-label-new">TAG KECIL (KIRI ATAS)</label>
          <input type="text" name="skill_tag" value="{{ $profile->about_sub_3 ?: '02 / LATAR Belakang SKILL' }}" required class="form-control-new">
        </div>
        <div>
          <label class="form-label-new">JUDUL UTAMA (KIRI BAWAH)</label>
          <input type="text" name="skill_title" value="{{ $profile->about_sub_2 ?: 'LATAR BELAKANG SKILL' }}" required class="form-control-new">
        </div>
      </div>

      <div class="form-group-new" style="margin-bottom: 0;">
        <label class="form-label-new">DESKRIPSI UTAMA (SEBELAH KANAN)</label>
        <textarea name="skill_desc" rows="3" required class="form-control-new" style="resize: vertical;">{{ $profile->about_2 ?: 'Dokumentasi kegiatan pemrograman web, desain UI/UX, dan organisasi sosial.' }}</textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; margin-top: 24px;">
        <button type="submit" class="submit-btn-glow"><i class='bx bx-save' style="font-size: 18px;"></i> Simpan Header Utama</button>
      </div>
    </div>
  </form>

  <!-- DATA YANG SUDAH ADA -->
  <div>
    <h3 style="font-size: 18px; margin-bottom: 6px; color: #fff; font-family: 'Sora', sans-serif; font-weight:700; display: flex; align-items: center; gap: 8px;">
        <i class='bx bx-grid-alt' style="color: #4E9BE0;"></i> Data Modul Tersimpan
    </h3>
    <p style="font-size: 13.5px; color: #8792A6;"> Arahkan kursor ke kartu untuk memunculkan tombol <strong>Edit</strong> atau <strong>Hapus</strong>.</p>

    <div class="skill-grid">
        @if(isset($dataKeahlian))
            @foreach($dataKeahlian as $index => $item)
            @php
                $fotoHardcode = '';
                $deskripsiHardcode = '';
                if ($index == 0) {
                    $fotoHardcode = asset('uploads/1786586192_profil_IMG_20260707_112708_146.jpg');
                    $deskripsiHardcode = "Membangun sistem website dinamis dan responsif menggunakan PHP dan framework Laravel. Terbiasa mengelola database MySQL, merancang arsitektur MVC, dan menyusun kodingan backend yang rapi.";
                } elseif ($index == 1) {
                    $fotoHardcode = asset('uploads/1787207896_keahlian_IMG_20260715_071115_152.jpg');
                    $deskripsiHardcode = "Merancang antarmuka web dan aplikasi (UI) yang ramah pengguna, estetis, dan memiliki alur interaksi yang jelas (UX). Aktif mendesain grafis dan poster digital.";
                } else {
                    $fotoHardcode = asset('uploads/1786516895_g3_DSC07615.jpg');
                    $deskripsiHardcode = "Aktif mengasah kepemimpinan dan komunikasi sosial. Berpengalaman mengurus tata kelola administrasi sebagai Sekretaris Umum OSIS, serta Ketua Karang Taruna.";
                }
                $gambarUrl = (!empty($item->gambar) && file_exists(public_path('uploads/' . $item->gambar))) ? asset('uploads/' . $item->gambar) : $fotoHardcode; 
                $deskripsiTampil = !empty(trim($item->deskripsi)) ? $item->deskripsi : $deskripsiHardcode;
            @endphp

            <div class="card-item">
                <div class="action-buttons-float">
                    <a href="{{ route('admin.latar_belakang.edit', $item->id) }}" class="btn-float btn-float-edit" title="Edit Kartu Ini"><i class='bx bx-edit'></i></a>
                    <form action="{{ route('admin.latar_belakang.delete', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kartu ini permanen?');" style="margin: 0;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-float btn-float-delete" title="Hapus Kartu"><i class='bx bx-trash'></i></button>
                    </form>
                </div>
                <div class="card-image-wrap"><img src="{{ $gambarUrl }}" alt="Skill Image"></div>
                <div class="card-content">
                    <div class="card-module">{{ $item->modul }}</div>
                    <div class="card-title">{{ $item->judul }}</div>
                    <div class="card-desc">{{ \Illuminate\Support\Str::limit($deskripsiTampil, 90, '...') }}</div>
                    <div class="card-footer">
                        <span class="card-cat">{{ $item->kategori }}</span>
                        <a href="{{ route('admin.latar_belakang.edit', $item->id) }}" class="card-detail" onmouseover="this.style.color='#4E9BE0'" onmouseout="this.style.color='#8792A6'">Edit detail &rarr;</a>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
  </div>

  <!-- FORM 2: TAMBAH ITEM BARU (2 KOLOM SEMPURNA) -->
  <form action="{{ route('admin.latar_belakang.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="glass-card" style="margin-top: 30px;">
      
      <div class="form-title" style="margin-bottom: 35px;">
          <div class="icon-wrap" style="color: #34C77B; background: rgba(52, 199, 123, 0.1);"><i class='bx bx-plus-circle'></i></div>
          Tambah Modul Baru
      </div>

      <div class="add-new-layout">
          <!-- KOLOM KIRI: UPLOAD GAMBAR SUPER PAS -->
          <div class="upload-pro-container" onclick="document.getElementById('file-upload-pro').click()">
              <img id="preview-img-pro" src="" alt="Preview">
              
              <div class="upload-placeholder" id="placeholder-pro">
                  <i class='bx bx-image-add'></i>
                  <p>Pilih Gambar</p>
                  <span>Maks: 2MB (JPG/PNG)</span>
              </div>
          </div>
          <input type="file" id="file-upload-pro" name="gambar" accept="image/*" required style="display: none;" onchange="previewProImage(event)">

          <!-- KOLOM KANAN: FORM TEKS -->
          <div>
              <div class="grid2">
                  <div class="form-group-new">
                      <label class="form-label-new">Teks Modul Atas</label>
                      <input type="text" name="modul" required class="form-control-new" placeholder="Contoh: MODULE / 01">
                  </div>
                  <div class="form-group-new">
                      <label class="form-label-new">Kategori Bawah</label>
                      <input type="text" name="kategori" required class="form-control-new" placeholder="Contoh: DEVELOPMENT">
                  </div>
              </div>

              <div class="form-group-new">
                  <label class="form-label-new">Judul Keahlian Utama</label>
                  <input type="text" name="judul" required class="form-control-new" placeholder="Contoh: Pemrograman Web & Laravel" style="font-weight: 600; color: #fff;">
              </div>

              <div class="form-group-new" style="margin-bottom: 0;">
                  <label class="form-label-new">Deskripsi Panjang (Muncul di Pop-up)</label>
                  <textarea name="deskripsi" rows="6" required class="form-control-new" placeholder="Tuliskan penjelasan detail tentang modul ini di sini..." style="resize: vertical; line-height: 1.6;"></textarea>
              </div>

              <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                  <button type="submit" class="submit-btn-glow" style="background: linear-gradient(135deg, #34C77B, #229A5C); box-shadow: 0 8px 20px rgba(52, 199, 123, 0.3); padding: 14px 40px;">
                      <i class='bx bx-check-shield' style="font-size: 20px;"></i> Simpan Modul
                  </button>
              </div>
          </div>
      </div>

    </div>
  </form>
</div>

<script>
  function previewProImage(event) {
      const file = event.target.files[0];
      if(file){
          const reader = new FileReader();
          reader.onload = function(e){
              document.getElementById('preview-img-pro').src = e.target.result;
              document.getElementById('preview-img-pro').style.display = 'block';
              document.getElementById('placeholder-pro').style.display = 'none';
              
              // Ubah border menjadi solid agar terkesan rapi saat gambar masuk
              event.target.closest('.upload-pro-container').style.borderStyle = 'solid';
          }
          reader.readAsDataURL(file);
      }
  }
</script>
@endsection