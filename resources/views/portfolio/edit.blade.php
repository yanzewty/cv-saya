<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Portofolio - {{ $profile->name ?? 'Admin' }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  :root{
    --bg:#0A0E17; --panel:#10151F; --panel-2:#141B29; --line:#232D3E; --text:#EAEEF5; --dim:#8792A6;
    --violet:#3763E0; --pink:#5C7A9E; --cyan:#4E9BE0; --gold:#C9A24A;
    --font-display:'Sora',sans-serif; --font-body:'Inter',sans-serif; --font-mono:'JetBrains Mono',monospace;
  }
  *{ margin:0; padding:0; box-sizing:border-box; }
  body{ background:var(--bg); color:var(--text); font-family:var(--font-body); min-height:100vh; padding:56px 20px; position:relative; overflow-x:hidden; }
  .mesh{ position:fixed; inset:0; z-index:0; overflow:hidden; }
  .blob{ position:absolute; border-radius:50%; filter:blur(60px); opacity:.2; will-change:transform; }
  .b1{ width:420px; height:420px; background:var(--violet); top:-15%; left:-10%; animation:float1 26s ease-in-out infinite; }
  .b2{ width:360px; height:360px; background:var(--cyan); bottom:-15%; right:-10%; animation:float2 30s ease-in-out infinite; }
  @keyframes float1{ 0%,100%{transform:translate(0,0);} 50%{transform:translate(40px,30px);} }
  @keyframes float2{ 0%,100%{transform:translate(0,0);} 50%{transform:translate(-30px,-25px);} }
  @media (prefers-reduced-motion: reduce){
    *, *::before, *::after{ animation-duration:.01ms !important; animation-iteration-count:1 !important; transition-duration:.01ms !important; }
  }

  .wrap{ position:relative; z-index:2; max-width:760px; margin:0 auto; background:linear-gradient(160deg, var(--panel-2), var(--panel));
    border:1px solid var(--line); border-radius:22px; overflow:hidden; box-shadow:0 30px 60px -20px rgba(0,0,0,.6); }
  .titlebar{ display:flex; align-items:center; gap:8px; padding:14px 22px; border-bottom:1px solid var(--line); background:rgba(0,0,0,.2); }
  .dot{ width:10px; height:10px; border-radius:50%; }
  .titlebar span:last-child{ margin-left:8px; font-family:var(--font-mono); font-size:11px; color:var(--dim); }

  .body{ padding:36px 40px; }
  .head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; padding-bottom:20px; border-bottom:1px solid var(--line); flex-wrap:wrap; gap:14px; }
  .head h1{ font-family:var(--font-display); font-weight:700; font-size:22px; display:flex; align-items:center; gap:10px; }
  .head p{ font-family:var(--font-mono); font-size:11.5px; color:var(--dim); margin-top:6px; }
  .btn-back{ padding:10px 18px; background:var(--bg); border:1px solid var(--line); border-radius:10px; font-size:12px; color:var(--dim); display:inline-flex; align-items:center; gap:8px; transition:border-color .2s, color .2s; }
  .btn-back:hover{ border-color:var(--cyan); color:var(--text); }

  .alert{ margin-bottom:22px; padding:14px 16px; border-radius:12px; font-size:13px; display:flex; align-items:flex-start; gap:10px; }
  .alert-ok{ background:rgba(78,225,214,.1); border:1px solid rgba(78,225,214,.35); color:var(--cyan); }
  .alert-err{ background:rgba(255,93,162,.1); border:1px solid rgba(255,93,162,.35); color:var(--pink); margin-bottom:10px; }

  form{ display:flex; flex-direction:column; gap:24px; }
  .panel{ background:var(--bg); border:1px solid var(--line); border-radius:16px; padding:24px; }
  label{ font-family:var(--font-mono); font-size:11px; text-transform:uppercase; letter-spacing:1px; color:var(--dim); display:block; margin-bottom:8px; }
  input[type=text], input[type=email], textarea{ width:100%; padding:12px 14px; background:var(--panel); border:1px solid var(--line); border-radius:10px; color:var(--text); font-size:13.5px; transition:border-color .2s; font-family:var(--font-body); }
  input:focus, textarea:focus{ outline:none; border-color:var(--violet); }
  .grid2{ display:grid; grid-template-columns:1fr 1fr; gap:20px; }
  @media (max-width:600px){ .grid2{ grid-template-columns:1fr; } .body{ padding:26px 20px; } }

  .photo-row{ display:flex; align-items:center; gap:22px; flex-wrap:wrap; }
  .photo-preview{ width:80px; height:80px; border-radius:16px; object-fit:cover; border:2px solid var(--violet); flex-shrink:0; }
  .photo-placeholder{ width:80px; height:80px; border-radius:16px; background:var(--panel); border:2px solid var(--line); display:flex; align-items:center; justify-content:center; color:var(--dim); font-size:26px; flex-shrink:0; }
  .upload-label{ display:inline-flex; align-items:center; gap:8px; padding:10px 18px; background:linear-gradient(90deg,var(--violet),var(--pink)); color:#fff; font-size:12px; font-weight:600; border-radius:10px; cursor:pointer; }
  .file-name{ font-size:11.5px; color:var(--dim); font-style:italic; margin-left:10px; }

  .gallery-row{ display:flex; align-items:center; gap:16px; padding-bottom:18px; border-bottom:1px solid var(--line); flex-wrap:wrap; }
  .gallery-row:last-child{ border-bottom:none; padding-bottom:0; }
  .gallery-thumb{ width:60px; height:60px; border-radius:12px; overflow:hidden; background:var(--panel); border:1px solid var(--line); flex-shrink:0; }
  .gallery-thumb img{ width:100%; height:100%; object-fit:cover; }
  input[type=file]{ font-size:12px; color:var(--dim); }
  input[type=file]::file-selector-button{ margin-right:14px; padding:9px 16px; border-radius:10px; border:none; font-size:11.5px; font-weight:600;
    background:linear-gradient(90deg,var(--violet),var(--pink)); color:#fff; cursor:pointer; }

  .exp-title{ font-family:var(--font-mono); font-size:11px; text-transform:uppercase; letter-spacing:1px; color:var(--gold); margin-bottom:14px; display:block; }

  .submit-btn{ padding:15px; border:none; border-radius:12px; cursor:pointer; background:linear-gradient(90deg,var(--violet),var(--pink),var(--cyan));
    background-size:200% auto; color:#0A0A12; font-family:var(--font-mono); font-weight:700; font-size:13.5px; transition:background-position .4s; }
  .submit-btn:hover{ background-position:100% center; }
</style>
</head>
<body>
<div class="mesh"><div class="blob b1"></div><div class="blob b2"></div></div>

<div class="wrap">
  <div class="titlebar">
    <span class="dot" style="background:#ff5f56"></span>
    <span class="dot" style="background:#ffbd2e"></span>
    <span class="dot" style="background:#27c93f"></span>
    <span>admin</span>
  </div>

  <div class="body">
    <div class="head">
      <div>
        <h1><i class="fas fa-user-edit" style="color:var(--violet)"></i> Edit Portofolio &amp; Pengalaman</h1>
        <p>// ubah data profil dan gambar lewat form di bawah ini</p>
      </div>
      <a href="{{ route('portofolio.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Web</a>
    </div>

    @if(session('success'))
      <div class="alert alert-ok"><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>
    @endif

    @if ($errors->any())
      <div style="margin-bottom:12px;">
        @foreach ($errors->all() as $error)
          <div class="alert alert-err"><i class="fas fa-exclamation-triangle"></i><span>{{ $error }}</span></div>
        @endforeach
      </div>
    @endif

    <form action="{{ route('portofolio.update') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- FOTO PROFIL UTAMA -->
      <div class="panel photo-row">
        @if(!empty($profile->photo) && file_exists(public_path('uploads/' . $profile->photo)))
          <img src="{{ asset('uploads/' . $profile->photo) }}" alt="Foto Profil" class="photo-preview">
        @else
          <div class="photo-placeholder"><i class="fas fa-user"></i></div>
        @endif
        <div>
          <label style="margin-bottom:6px;"><i class="fas fa-camera" style="color:var(--violet)"></i> Foto Profil Utama</label>
          <p style="font-size:11.5px;color:var(--dim);margin-bottom:10px;">Pilih foto terbaikmu (Format: JPG/PNG - Maks. 2MB)</p>
          <label class="upload-label">
            <i class="fas fa-upload"></i> Pilih Foto Baru
            <input type="file" name="photo" accept="image/*" style="display:none;" onchange="document.getElementById('file-name-photo').textContent = this.files[0] ? this.files[0].name : 'Belum ada file dipilih'">
          </label>
          <span id="file-name-photo" class="file-name">Belum ada file dipilih</span>
        </div>
      </div>

      <!-- GALERI 1-3 -->
      <div class="panel" style="display:flex;flex-direction:column;gap:18px;">
        <label style="color:var(--gold);"><i class="fas fa-images"></i> Foto Galeri &amp; Proyek (Maks. 2MB per gambar)</label>
        @php
          $defaultImages = [
            1 => 'https://img.freepik.com/free-vector/programming-concept-illustration_114360-1351.jpg',
            2 => 'https://img.freepik.com/free-vector/ui-ux-designers-concept-illustration_114360-6331.jpg',
            3 => 'https://img.freepik.com/free-vector/team-goals-concept-illustration_114360-5231.jpg'
          ];
        @endphp
        @for($i = 1; $i <= 3; $i++)
        <div class="gallery-row">
          <div class="gallery-thumb">
            @php $galleryField = "gallery_$i"; @endphp
            @if(!empty($profile->$galleryField) && file_exists(public_path('uploads/' . $profile->$galleryField)))
              <img src="{{ asset('uploads/' . $profile->$galleryField) }}">
            @else
              <img src="{{ $defaultImages[$i] }}">
            @endif
          </div>
          <div style="flex:1;min-width:180px;">
            <label style="margin-bottom:6px;">Gambar Galeri {{ $i }}</label>
            <input type="file" name="gallery_{{ $i }}" accept="image/*">
          </div>
        </div>
        @endfor
      </div>

      <!-- INFO UTAMA -->
      <div class="grid2">
        <div>
          <label>Nama Lengkap</label>
          <input type="text" name="name" value="{{ $profile->name }}" required>
        </div>
        <div>
          <label>Role / Posisi Utama</label>
          <input type="text" name="role" value="{{ $profile->role }}" required>
        </div>
      </div>

      <div>
        <label>Tentang Saya (Bio)</label>
        <textarea name="about" rows="4" required>{{ $profile->about }}</textarea>
      </div>

      <div class="grid2">
        <div>
          <label>Email</label>
          <input type="email" name="email" value="{{ $profile->email }}" required>
        </div>
        <div>
          <label>Nomor Telepon</label>
          <input type="text" name="phone" value="{{ $profile->phone }}" required>
        </div>
      </div>

      <div>
        <label>Alamat</label>
        <input type="text" name="address" value="{{ $profile->address }}" required>
      </div>

      <div>
        <label>Skills (Pisahkan koma)</label>
        <input type="text" name="skills" value="{{ $profile->skills }}">
      </div>

      @for($i = 1; $i <= 2; $i++)
      <div class="panel" style="display:flex;flex-direction:column;gap:14px;">
        <span class="exp-title"><i class="fas fa-briefcase"></i> Pengalaman {{ $i }}</span>
        <div class="grid2">
          <input type="text" name="exp{{$i}}_period" value="{{ $profile->{'exp'.$i.'_period'} ?? '' }}" placeholder="Periode">
          <input type="text" name="exp{{$i}}_title" value="{{ $profile->{'exp'.$i.'_title'} ?? '' }}" placeholder="Judul / Posisi">
        </div>
        <input type="text" name="exp{{$i}}_place" value="{{ $profile->{'exp'.$i.'_place'} ?? '' }}" placeholder="Instansi">
        <textarea name="exp{{$i}}_desc" rows="2" placeholder="Deskripsi">{{ $profile->{'exp'.$i.'_desc'} ?? '' }}</textarea>
      </div>
      @endfor

      <button type="submit" class="submit-btn">Simpan Semua Perubahan</button>
    </form>
  </div>
</div>

<script>
  const form = document.querySelector('form');
  const maxSize = 2 * 1024 * 1024; // 2MB

  form.addEventListener('submit', function(e) {
    const fileInputs = form.querySelectorAll('input[type="file"]');
    let isLarge = false;
    fileInputs.forEach(input => {
      if (input.files.length > 0 && input.files[0].size > maxSize) isLarge = true;
    });
    if (isLarge) {
      e.preventDefault();
      alert("⚠️ PERINGATAN: Salah satu file yang kamu pilih ukurannya melebihi 2MB! Silakan pilih file yang lebih kecil.");
    }
  });
</script>
</body>
</html>