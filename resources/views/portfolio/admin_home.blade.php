@extends('portfolio.admin_layout')
@section('title', 'Kelola Home')

@section('content')
<style>
  .avatar-upload-area { display: flex; align-items: center; gap: 24px; padding-bottom: 26px; border-bottom: 1px solid var(--line); margin-bottom: 26px; flex-wrap: wrap; }
  .avatar-preview-box { position: relative; width: 96px; height: 96px; border-radius: 50%; padding: 3px; background: linear-gradient(135deg, var(--violet), var(--cyan)); flex-shrink: 0; box-shadow: 0 12px 28px -8px rgba(41,199,192,0.35); }
  .avatar-preview-box img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 3px solid var(--panel); }

  .upload-controls { display: flex; flex-direction: column; gap: 10px; }
  .file-input-wrapper { position: relative; overflow: hidden; display: inline-block; }
  .file-input-wrapper input[type=file] { position: absolute; left: 0; top: 0; opacity: 0; cursor: pointer; height: 100%; width: 100%; }
  .btn-upload-custom { background: rgba(41,199,192,0.10); color: var(--cyan); border: 1px solid rgba(41,199,192,0.4); padding: 10px 20px; border-radius: 30px; font-size: 12.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s var(--ease); }
  .file-input-wrapper:hover .btn-upload-custom { background: var(--cyan); color: #06231f; border-color: var(--cyan); }
  .upload-hint { font-size: 11.5px; color: var(--dim); }
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

  @if (session('success_msg'))
    <div class="alert-succ"><i class='bx bx-check-circle' style="font-size: 18px;"></i> <span>{{ session('success_msg') }}</span></div>
  @endif

  <form action="{{ route('admin.home.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card-form" style="--accent: var(--cyan);">
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
          <span class="upload-hint">Format yang diizinkan: JPG, JPEG, PNG. Max 2MB.</span>
        </div>
      </div>

      <div class="grid2">
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" value="{{ $profile->name }}" required placeholder="Contoh: Alfiansyah Ibdani">
        </div>
        <div class="form-group">
          <label>Judul</label>
          <input type="text" name="role" value="{{ $profile->role }}" required placeholder="Contoh: IT Engineering & Web Developer_">
        </div>
      </div>
    </div>

    <div class="card-form" style="--accent: var(--gold);">
      <div class="form-title"><i class='bx bx-message-square-detail'></i> Bio Singkat &amp; Kontak</div>

      <div class="form-group">
        <label>Bio Singkat</label>
        <textarea name="about" rows="3" required placeholder="Tuliskan deskripsi singkat tentang dirimu...">{{ $profile->about }}</textarea>
      </div>

      <div class="grid2">
        <div class="form-group">
          <label>Email Publik</label>
          <input type="email" name="email" value="{{ $profile->email }}" required placeholder="emailmu@gmail.com">
        </div>
        <div class="form-group">
          <label>Nomor Telepon (WhatsApp)</label>
          <input type="text" name="phone" value="{{ $profile->phone }}" required placeholder="088235921495">
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 0;">
        <label>Alamat / Lokasi</label>
        <input type="text" name="address" value="{{ $profile->address }}" required placeholder="Contoh: Menganti, Gresik">
      </div>
    </div>

    <div class="card-form" style="--accent: var(--violet);">
      <div class="form-title"><i class='bx bx-layer'></i> Elemen Tambahan (Kosongkan apabila tidak di gunakan)</div>

      <div class="grid2">
        <div class="form-group">
          <label>Teks Badge 1</label>
          <input type="text" name="badge_1" value="{{ $profile->badge_1 }}" placeholder="Contoh: Sekrum OSIS 2025-2026">
        </div>
        <div class="form-group">
          <label>Teks Badge 2</label>
          <input type="text" name="badge_2" value="{{ $profile->badge_2 }}" placeholder="Contoh: </> Web Dev & UI/UX">
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 0;">
        <label>Banner</label>
        <input type="text" name="skills" value="{{ is_array(json_decode($profile->skills, true)) ? implode(', ', json_decode($profile->skills, true)) : $profile->skills }}" placeholder="Pisahkan dengan koma. Contoh: HTML, CSS, Laravel">
        <span class="upload-hint" style="margin-top: 6px; display: block;">*Teks ini akan berjalan (running text)</span>
      </div>
    </div>

    <button type="submit" class="submit-btn"><i class='bx bx-save'></i> Simpan Perubahan</button>
  </form>
</div>

<script>
  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
      document.getElementById('image-preview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  }
</script>
@endsection