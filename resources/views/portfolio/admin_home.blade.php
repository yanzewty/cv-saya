@extends('portfolio.admin_layout')
@section('title', 'Kelola Home')

@section('content')
<style>
  .wrap-form { max-width: 900px; margin: 0 auto; padding-bottom: 40px; }
  .header-flex { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 35px; }
  .btn-outline { padding: 10px 18px; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; font-size: 13px; color: var(--text); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; font-weight: 500; background: rgba(255,255,255,0.02); }
  .btn-outline:hover { border-color: var(--cyan); color: #fff; background: rgba(78, 225, 214, 0.1); }
  
  .alert-succ { background:rgba(46,213,115,0.1); border:1px solid rgba(46,213,115,0.3); color:#2ed573; padding: 16px 20px; border-radius: 12px; font-size: 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 24px; font-weight: 500; }
  
  /* Desain Card Modern */
  .card-form { background: var(--panel); border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 35px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); position: relative; overflow: hidden; }
  .card-form::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(180deg, var(--cyan), var(--violet)); border-radius: 4px 0 0 4px; }
  
  .form-title { font-size: 16px; color: #fff; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; font-weight: 700; font-family: 'Sora', sans-serif; letter-spacing: 0.5px; }
  .form-title i { color: var(--cyan); font-size: 20px; }
  
  /* Custom File Upload UI */
  .avatar-upload-area { display: flex; align-items: center; gap: 25px; padding-bottom: 30px; border-bottom: 1px dashed rgba(255,255,255,0.1); margin-bottom: 30px; }
  .avatar-preview-box { position: relative; width: 110px; height: 110px; border-radius: 50%; padding: 4px; background: linear-gradient(135deg, var(--violet), var(--cyan)); box-shadow: 0 10px 25px rgba(78, 225, 214, 0.2); }
  .avatar-preview-box img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 3px solid var(--panel); }
  
  .upload-controls { display: flex; flex-direction: column; gap: 10px; }
  .file-input-wrapper { position: relative; overflow: hidden; display: inline-block; }
  .file-input-wrapper input[type=file] { position: absolute; left: 0; top: 0; opacity: 0; cursor: pointer; height: 100%; width: 100%; }
  .btn-upload-custom { background: rgba(78, 225, 214, 0.1); color: var(--cyan); border: 1px solid var(--cyan); padding: 10px 20px; border-radius: 30px; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s; }
  .file-input-wrapper:hover .btn-upload-custom { background: var(--cyan); color: #000; box-shadow: 0 0 15px rgba(78, 225, 214, 0.4); }
  .upload-hint { font-size: 11px; color: var(--dim); }

  /* Input Fields */
  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
  .input-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
  .input-group label { font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--dim); }
  .input-group input, .input-group textarea { width: 100%; padding: 16px; background: rgba(0,0,0,0.25); border: 1px solid var(--line); border-radius: 12px; color: #fff; font-size: 14px; transition: all 0.3s; font-family: 'Inter', sans-serif; }
  .input-group input:focus, .input-group textarea:focus { outline: none; border-color: var(--cyan); box-shadow: 0 0 0 3px rgba(78, 225, 214, 0.15); background: rgba(0,0,0,0.4); }
  
  .submit-btn { width: 100%; padding: 18px; border: none; border-radius: 14px; cursor: pointer; background: linear-gradient(90deg, var(--violet), var(--cyan)); color: #fff; font-size: 15px; font-weight: 700; transition: all 0.3s; display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 10px; }
  .submit-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(78, 225, 214, 0.3); filter: brightness(1.1); }
</style>

<div class="wrap-form">
  <div class="header-flex">
    <div>
      <h1 style="font-family: 'Sora', sans-serif; font-size: 32px; margin-bottom: 5px; color: #fff;">Kelola Home</h1>
      <p style="color: var(--dim); font-size: 14px;">Atur foto profil dan informasi utama halaman depan portofoliomu.</p>
    </div>
    <a href="{{ route('portofolio.index') }}" target="_blank" class="btn-outline">
      <i class='bx bx-link-external'></i> Lihat Website
    </a>
  </div>

  
  <form action="{{ route('admin.home.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- CARD 1: IDENTITAS & FOTO -->
    <div class="card-form">
      <div class="form-title"><i class='bx bx-user-circle'></i> Identitas Utama</div>
      
      <!-- Area Upload Foto Premium -->
      <div class="avatar-upload-area">
        <div class="avatar-preview-box">
          @if(!empty($profile->photo) && file_exists(public_path('uploads/' . $profile->photo)))
            <img id="image-preview" src="{{ asset('uploads/' . $profile->photo) }}" alt="Foto Profil">
          @else
            <img id="image-preview" src="https://img.freepik.com/free-vector/cute-boy-working-laptop-cartoon-vector-icon-illustration-people-technology-icon-concept-isolated-premium-vector-flat-cartoon-style_138676-3522.jpg" alt="Foto Profil">
          @endif
        </div>
        <div class="upload-controls">
          <div class="file-input-wrapper">
            <button type="button" class="btn-upload-custom">
              <i class='bx bx-camera'></i> Ganti Foto Profil
            </button>
            <input type="file" name="photo" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event)">
          </div>
          <span class="upload-hint">Format yang diizinkan: JPG, JPEG, PNG. Maks 2MB.</span>
        </div>
      </div>

      <div class="grid2">
        <div class="input-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" value="{{ $profile->name }}" required placeholder="Contoh: Alfiansyah Ibdani">
        </div>
        <div class="input-group">
          <label>Role / Posisi Utama (Animasi Ketik)</label>
          <input type="text" name="role" value="{{ $profile->role }}" required placeholder="Contoh: IT Engineering & Web Developer_">
        </div>
      </div>
    </div>

    <!-- CARD 2: BIO & KONTAK -->
    <div class="card-form" style="border-left-color: var(--pink);">
      <div class="form-title" style="color: #ffab00;"><i class='bx bx-message-square-detail'></i> Bio Singkat & Kontak</div>
      
      <div class="input-group">
        <label>Bio Singkat (Tampil di bawah nama)</label>
        <textarea name="about" rows="3" required placeholder="Tuliskan deskripsi singkat tentang dirimu...">{{ $profile->about }}</textarea>
      </div>

      <div class="grid2">
        <div class="input-group">
          <label>Email Publik</label>
          <input type="email" name="email" value="{{ $profile->email }}" required placeholder="emailmu@gmail.com">
        </div>
        <div class="input-group">
          <label>Nomor Telepon (WhatsApp)</label>
          <input type="text" name="phone" value="{{ $profile->phone }}" required placeholder="088235921495">
        </div>
      </div>
      
      <div class="input-group" style="margin-bottom: 0;">
        <label>Alamatf / Lokasi</label>
        <input type="text" name="address" value="{{ $profile->address }}" required placeholder="Contoh: Menganti, Gresik">
      </div>
    </div>

    <!-- CARD 3: ELEMEN TAMBAHAN (BADGE & SKILL MARQUEE) -->
    <div class="card-form" style="border-left-color: var(--violet);">
      <div class="form-title" style="color: #e056fd;"><i class='bx bx-layer'></i> Elemen Tambahan (Badge Mengambang)</div>
      
      <div class="grid2">
        <div class="input-group">
          <label>Teks Badge 1 (Kanan Atas Foto)</label>
          <input type="text" name="badge_1" value="{{ $profile->badge_1 }}" placeholder="Contoh: Sekrum OSIS 2025-2026">
        </div>
        <div class="input-group">
          <label>Teks Badge 2 (Kiri Bawah Foto)</label>
          <input type="text" name="badge_2" value="{{ $profile->badge_2 }}" placeholder="Contoh: < /> Web Dev & UI/UX">
        </div>
      </div>

      <div class="input-group" style="margin-bottom: 0;">
        <label>Skill Berjalan (Marquee Text)</label>
        <input type="text" name="skills" value="{{ is_array(json_decode($profile->skills, true)) ? implode(', ', json_decode($profile->skills, true)) : $profile->skills }}" placeholder="Pisahkan dengan koma. Contoh: HTML, CSS, Laravel">
        <span class="upload-hint" style="margin-top: 4px;">*Teks ini akan berjalan (running text) di bawah tombol Hubungi Saya.</span>
      </div>
    </div>

    <button type="submit" class="submit-btn"><i class='bx bx-save'></i> Simpan Perubahan</button>
  </form>
</div>

<!-- SCRIPT UNTUK LIVE PREVIEW FOTO -->
<script>
  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
      const output = document.getElementById('image-preview');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  }
</script>
@endsection