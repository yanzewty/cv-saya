@extends('portfolio.admin_layout')
@section('title', 'Kelola Home')

@section('content')
<style>
  .wrap-form { max-width: 800px; }
  .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
  .btn-outline { padding: 10px 18px; border: 1px solid var(--line); border-radius: 10px; font-size: 13px; color: var(--text); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
  .btn-outline:hover { border-color: var(--primary); color: var(--primary); background: rgba(55,99,224,0.1); }

  .alert-err { background:rgba(255,95,86,0.1); border:1px solid rgba(255,95,86,0.3); color:var(--danger); padding: 14px 16px; border-radius: 12px; font-size: 13px; display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
  .alert-succ { background:rgba(46,213,115,0.1); border:1px solid rgba(46,213,115,0.3); color:#2ed573; padding: 14px 16px; border-radius: 12px; font-size: 13px; display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }

  .card-form { background: var(--panel); border: 1px solid var(--line); border-radius: 16px; padding: 30px; margin-bottom: 24px; }
  .form-group { margin-bottom: 20px; }
  label { font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: var(--dim); display: block; margin-bottom: 8px; }
  input[type=text], input[type=email], textarea { width: 100%; padding: 14px 16px; background: var(--bg); border: 1px solid var(--line); border-radius: 10px; color: var(--text); font-size: 14px; transition: border-color 0.2s; }
  input:focus, textarea:focus { outline: none; border-color: var(--primary); }
  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
  @media (max-width: 600px) { .grid2 { grid-template-columns: 1fr; } }

  .photo-row { display: flex; align-items: center; gap: 22px; flex-wrap: wrap; }
  .photo-preview { width: 90px; height: 90px; border-radius: 16px; object-fit: cover; border: 2px solid var(--primary); flex-shrink: 0; }
  .photo-placeholder { width: 90px; height: 90px; border-radius: 16px; background: var(--bg); border: 2px dashed var(--line); display: flex; align-items: center; justify-content: center; color: var(--dim); font-size: 30px; flex-shrink: 0; }
  .upload-label { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; background: var(--primary); color: #fff; font-size: 13px; font-weight: 600; border-radius: 10px; cursor: pointer; transition: 0.2s; }
  .upload-label:hover { filter: brightness(1.1); }
  .file-name { font-size: 12px; color: var(--dim); font-style: italic; margin-left: 10px; }

  .submit-btn { width: 100%; padding: 16px; border: none; border-radius: 12px; cursor: pointer; background: var(--primary); color: #fff; font-size: 14px; font-weight: 600; transition: 0.2s; display: flex; justify-content: center; align-items: center; gap: 8px; letter-spacing: 0.5px;}
  .submit-btn:hover { background: #2b4eb5; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(55,99,224,0.3); }

  /* Modal Custom Alert */
  .custom-modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(10, 14, 23, 0.8); backdrop-filter: blur(5px); z-index: 9999; display: none; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease; }
  .custom-modal-overlay.show-overlay { opacity: 1; display: flex; }
  .custom-modal { background: var(--panel); border: 1px solid rgba(255,95,86,0.4); border-radius: 20px; padding: 34px; width: 90%; max-width: 400px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.5); transform: translateY(20px) scale(0.95); transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
  .custom-modal.show-modal { transform: translateY(0) scale(1); }
  .custom-modal i { font-size: 56px; color: var(--danger); margin-bottom: 18px; filter: drop-shadow(0 0 10px rgba(255,95,86,0.4)); }
  .custom-modal h3 { font-size: 22px; color: var(--text); margin-bottom: 12px; font-family: 'Sora', sans-serif; }
  .custom-modal p { font-size: 14px; color: var(--dim); line-height: 1.6; margin-bottom: 24px; }
  .custom-modal button { padding: 12px 28px; background: rgba(255,95,86,0.1); border: 1px solid rgba(255,95,86,0.3); color: var(--danger); border-radius: 12px; cursor: pointer; font-weight: 600; font-size: 14px; transition: 0.2s; width: 100%; }
  .custom-modal button:hover { background: var(--danger); color: #fff; }
</style>

<div class="wrap-form">
  <div class="header-flex">
    <div>
      <h1 style="font-family: 'Sora', sans-serif; font-size: 28px; margin-bottom: 5px;">Kelola Home</h1>
      <p style="color: var(--dim); font-size: 14px;">Atur foto profil dan informasi utama halaman depan portofoliomu.</p>
    </div>
    <a href="{{ route('portofolio.index') }}" target="_blank" class="btn-outline">
      <i class='bx bx-link-external'></i> Lihat Website
    </a>
  </div>

  @if (session('success_msg'))
    <div class="alert-succ"><i class='bx bx-check-circle'></i> <span>{{ session('success_msg') }}</span></div>
  @endif

  @if ($errors->any())
    <div style="margin-bottom: 24px;">
      @foreach ($errors->all() as $error)
        <div class="alert-err"><i class='bx bx-error-circle'></i> <span>{{ $error }}</span></div>
      @endforeach
    </div>
  @endif

  <form action="{{ route('admin.home.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- FOTO PROFIL UTAMA -->
    <div class="card-form photo-row">
      <div id="photo-container">
        @if(!empty($profile->photo) && file_exists(public_path('uploads/' . $profile->photo)))
          <img id="preview-photo" src="{{ asset('uploads/' . $profile->photo) }}" alt="Foto Profil" class="photo-preview">
        @else
          <img id="preview-photo" src="" alt="Foto Profil" class="photo-preview" style="display:none;">
          <div id="photo-placeholder" class="photo-placeholder"><i class='bx bx-user'></i></div>
        @endif
      </div>
      <div>
        <label style="display:flex; align-items:center; gap:6px;"><i class='bx bx-camera' style="font-size:16px; color:var(--primary)"></i> Foto Profil Utama</label>
        <p style="font-size: 12px; color: var(--dim); margin-bottom: 12px; text-transform:none;">Format: JPG/PNG - Maks. 2MB</p>
        <label class="upload-label">
          <i class='bx bx-upload'></i> Pilih Foto
          <input type="file" name="photo" accept="image/*" style="display:none;" onchange="updateProfilePreview(this)">
        </label>
        <span id="file-name-photo" class="file-name">Belum ada file dipilih</span>
      </div>
    </div>

    <!-- INFO DATA DIRI -->
    <div class="card-form">
      <div class="grid2">
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" value="{{ $profile->name ?? '' }}" required>
        </div>
        <div class="form-group">
          <label>Role / Posisi Utama</label>
          <input type="text" name="role" value="{{ $profile->role ?? '' }}" placeholder="Contoh: Web Developer" required>
        </div>
      </div>

      <div class="form-group">
        <label>Bio Singkat (Tampil di Bawah Nama)</label>
        <textarea name="about" rows="3" required placeholder="Ceritakan sedikit tentang dirimu...">{{ $profile->about ?? '' }}</textarea>
      </div>

      <div class="grid2">
        <div class="form-group">
          <label>Email Publik</label>
          <input type="email" name="email" value="{{ $profile->email ?? '' }}" required>
        </div>
        <div class="form-group">
          <label>Nomor Telepon (WhatsApp)</label>
          <input type="text" name="phone" value="{{ $profile->phone ?? '' }}" required>
        </div>
      </div>

      <div class="form-group">
        <label>Alamat / Lokasi</label>
        <input type="text" name="address" value="{{ $profile->address ?? '' }}" required>
      </div>

      <div class="form-group" style="margin-bottom:0;">
        <label>Skills (Pisahkan dengan koma)</label>
        @php
            $skillsString = is_string($profile->skills) && is_array(json_decode($profile->skills, true)) 
                            ? implode(', ', json_decode($profile->skills, true)) 
                            : ($profile->skills ?? '');
        @endphp
        <input type="text" name="skills" value="{{ $skillsString }}" placeholder="HTML, CSS, Laravel...">
      </div>
    </div>

    <!-- BADGES (Teks Mengambang di Foto) -->
    <div class="card-form">
      <h3 style="font-size: 14px; margin-bottom: 15px; color: var(--primary);"><i class='bx bx-purchase-tag-alt'></i> Teks Mengambang di Foto Profil</h3>
      <div class="grid2">
        <div class="form-group" style="margin-bottom:0;">
          <label>Badge Atas (Opsional)</label>
          <input type="text" name="badge_1" value="{{ $profile->badge_1 ?? '' }}" placeholder="Contoh: Sekrum OSIS">
        </div>
        <div class="form-group" style="margin-bottom:0;">
          <label>Badge Bawah (Opsional)</label>
          <input type="text" name="badge_2" value="{{ $profile->badge_2 ?? '' }}" placeholder="Contoh: Web Dev">
        </div>
      </div>
    </div>

    <button type="submit" class="submit-btn"><i class='bx bx-save'></i> Simpan Perubahan Home</button>
  </form>
</div>

<!-- Modal Custom Alert (Gambar > 2MB) -->
<div id="sizeAlertModal" class="custom-modal-overlay">
  <div class="custom-modal" id="sizeAlertBox">
    <i class='bx bx-error'></i>
    <h3>File Terlalu Besar!</h3>
    <p>Aduh, foto yang kamu pilih ukurannya lebih dari <strong>2MB</strong>. Server butuh file yang lebih kecil, silakan kompres fotomu dulu ya.</p>
    <button type="button" onclick="closeAlert()">Mengerti, Ubah Foto</button>
  </div>
</div>

<script>
  function updateProfilePreview(input) {
    document.getElementById('file-name-photo').textContent = input.files[0] ? input.files[0].name : 'Belum ada file dipilih';
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('preview-photo').src = e.target.result;
        document.getElementById('preview-photo').style.display = 'block';
        const placeholder = document.getElementById('photo-placeholder');
        if (placeholder) placeholder.style.display = 'none';
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  const form = document.querySelector('form');
  const maxSize = 2 * 1024 * 1024; // 2MB
  const modalOverlay = document.getElementById('sizeAlertModal');
  const modalBox = document.getElementById('sizeAlertBox');

  form.addEventListener('submit', function(e) {
    const photoInput = form.querySelector('input[name="photo"]');
    if (photoInput && photoInput.files.length > 0 && photoInput.files[0].size > maxSize) {
      e.preventDefault(); 
      showAlert();        
    }
  });

  function showAlert() {
    modalOverlay.classList.add('show-overlay');
    setTimeout(() => modalBox.classList.add('show-modal'), 10);
  }

  function closeAlert() {
    modalBox.classList.remove('show-modal');
    setTimeout(() => modalOverlay.classList.remove('show-overlay'), 300);
  }
</script>
@endsection