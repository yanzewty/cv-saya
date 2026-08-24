@extends('portfolio.admin_layout')
@section('title', 'Kelola Home')

@section('content')
<style>
  .wrap-form { max-width: 900px; margin: 0 auto; padding-bottom: 40px; }
  .header-flex { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; }
  .header-flex h1 { font-family: var(--font-display); font-size: 28px; font-weight: 700; margin-bottom: 6px; }
  .header-flex p { color: var(--dim); font-size: 13.5px; }
  .btn-outline { padding: 10px 18px; border: 1px solid var(--line); border-radius: 10px; font-size: 13px; color: var(--text); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; background: rgba(255,255,255,0.02); }
  .btn-outline:hover { border-color: var(--cyan); color: #fff; background: rgba(41,199,192,0.10); }

  .card-form { background: var(--panel); border: 1px solid var(--line); border-radius: 20px; padding: 34px; margin-bottom: 26px; box-shadow: 0 20px 40px -28px rgba(0,0,0,0.6); position: relative; overflow: hidden; }
  .card-form::before { content: ''; position: absolute; top: 0; left: 0; width: 3px; height: 100%; background: linear-gradient(180deg, var(--cyan), var(--violet)); }

  .form-title { font-size: 15px; color: #fff; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; font-weight: 700; font-family: var(--font-display); letter-spacing: 0.2px; }
  .form-title i { color: var(--cyan); font-size: 19px; }

  .avatar-upload-area { display: flex; align-items: center; gap: 24px; padding-bottom: 28px; border-bottom: 1px solid var(--line); margin-bottom: 28px; }
  .avatar-preview-box { position: relative; width: 100px; height: 100px; border-radius: 50%; padding: 3px; background: linear-gradient(135deg, var(--violet), var(--cyan)); box-shadow: 0 12px 28px -8px rgba(41,199,192,0.35); }
  .avatar-preview-box img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 3px solid var(--panel); }

  .upload-controls { display: flex; flex-direction: column; gap: 10px; }
  .file-input-wrapper { position: relative; overflow: hidden; display: inline-block; }
  .file-input-wrapper input[type=file] { position: absolute; left: 0; top: 0; opacity: 0; cursor: pointer; height: 100%; width: 100%; }
  .btn-upload-custom { background: rgba(41,199,192,0.10); color: var(--cyan); border: 1px solid rgba(41,199,192,0.4); padding: 10px 20px; border-radius: 30px; font-size: 12.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: 0.25s; }
  .file-input-wrapper:hover .btn-upload-custom { background: var(--cyan); color: #06231f; border-color: var(--cyan); }
  .upload-hint { font-size: 11.5px; color: var(--dim); }

  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }
  @media (max-width: 620px) { .grid2 { grid-template-columns: 1fr; } }
  .input-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
  .input-group label { font-family: var(--font-mono); font-size: 10.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: var(--dim); }
  .input-group input, .input-group textarea { width: 100%; padding: 14px 15px; background: var(--bg); border: 1px solid var(--line); border-radius: 12px; color: #fff; font-size: 13.5px; transition: all 0.2s; font-family: 'Inter', sans-serif; }
  .input-group input:focus, .input-group textarea:focus { outline: none; border-color: var(--cyan); box-shadow: 0 0 0 3px rgba(41,199,192,0.15); }

  .submit-btn { width: 100%; padding: 16px; border: none; border-radius: 14px; cursor: pointer; background: linear-gradient(90deg, var(--violet), var(--cyan)); color: #05121a; font-size: 14px; font-weight: 700; transition: all 0.25s; display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 8px; }
  .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 16px 32px -12px rgba(41,199,192,0.4); }
</style>

<div class="wrap-form">
  <div class="header-flex">
    <div>
      <h1>Kelola Home</h1>
      <p>Atur foto profil dan informasi utama halaman depan portofoliomu.</p>
    </div>
    <a href="{{ route('portofolio.index') }}" target="_blank" class="btn-outline">
      <i class='bx bx-link-external'></i> Lihat Website
    </a>
  </div>

  <form action="{{ route('admin.home.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card-form">
      <div class="form-title"><i class='bx bx-user-circle'></i> Identitas Utama</div>

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

    <div class="card-form" style="--acc:var(--gold);">
      <div class="form-title" style="color: var(--gold);"><i class='bx bx-message-square-detail' style="color:var(--gold);"></i> Bio Singkat &amp; Kontak</div>

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
        <label>Alamat / Lokasi</label>
        <input type="text" name="address" value="{{ $profile->address }}" required placeholder="Contoh: Menganti, Gresik">
      </div>
    </div>

    <div class="card-form" style="--acc:var(--violet);">
      <div class="form-title" style="color: var(--violet);"><i class='bx bx-layer' style="color:var(--violet);"></i> Elemen Tambahan (Badge Mengambang)</div>

      <div class="grid2">
        <div class="input-group">
          <label>Teks Badge 1 (Kanan Atas Foto)</label>
          <input type="text" name="badge_1" value="{{ $profile->badge_1 }}" placeholder="Contoh: Sekrum OSIS 2025-2026">
        </div>
        <div class="input-group">
          <label>Teks Badge 2 (Kiri Bawah Foto)</label>
          <input type="text" name="badge_2" value="{{ $profile->badge_2 }}" placeholder="Contoh: </> Web Dev & UI/UX">
        </div>
      </div>

      <div class="input-group" style="margin-bottom: 0;">
        <label>Skill Berjalan (Marquee Text)</label>
        <input type="text" name="skills" value="{{ is_array(json_decode($profile->skills, true)) ? implode(', ', json_decode($profile->skills, true)) : $profile->skills }}" placeholder="Pisahkan dengan koma. Contoh: HTML, CSS, Laravel">
        <span class="upload-hint" style="margin-top: 4px; display:block;">*Teks ini akan berjalan (running text) di bawah tombol Hubungi Saya.</span>
      </div>
    </div>

    <button type="submit" class="submit-btn"><i class='bx bx-save'></i> Simpan Perubahan</button>
  </form>
</div>

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