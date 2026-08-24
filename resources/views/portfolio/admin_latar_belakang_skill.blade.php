@extends('portfolio.admin_layout')
@section('title', 'Kelola Latar Belakang Skill')

@section('content')
<style>
  .wrap-form { max-width: 1000px; margin: 0 auto; }
  .header-flex { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; }
  .header-flex h1 { font-family: var(--font-display); font-size: 28px; font-weight: 700; margin-bottom: 6px; }
  .header-flex p { color: var(--dim); font-size: 13.5px; }
  .btn-outline { padding: 10px 18px; border: 1px solid var(--line); border-radius: 10px; font-size: 13px; color: var(--text); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; background: rgba(255,255,255,0.02); }
  .btn-outline:hover { border-color: var(--primary); color: #fff; background: rgba(76,111,255,0.10); transform: translateY(-1px); }
  .alert-succ { background:rgba(52,199,123,0.10); border:1px solid rgba(52,199,123,0.28); color:var(--success); padding: 15px 18px; border-radius: 12px; font-size: 13.5px; display: flex; align-items: center; gap: 10px; margin-bottom: 24px; font-weight: 500; }

  .skill-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 22px; margin-top: 14px; margin-bottom: 46px; }
  .card-item { background: var(--panel); border: 1px solid var(--line); border-radius: 16px; overflow: hidden; position: relative; transition: 0.25s; box-shadow: 0 12px 26px -18px rgba(0,0,0,0.6); display: flex; flex-direction: column; }
  .card-item:hover { transform: translateY(-4px); border-color: rgba(232,163,61,0.35); }

  .card-image-wrap { position: relative; width: 100%; height: 170px; overflow: hidden; background: var(--bg); display: flex; align-items: center; justify-content: center; }
  .card-image-wrap img { width: 100%; height: 100%; object-fit: cover; }
  .no-img-text { color: var(--dim); font-size: 12px; font-style: italic; display: flex; align-items: center; gap: 6px; }

  .card-content { padding: 20px; flex: 1; display: flex; flex-direction: column; }
  .card-module { font-family: var(--font-mono); font-size: 10px; color: var(--dim); letter-spacing: 1.5px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; }
  .card-title { font-size: 17px; color: #fff; font-weight: 700; margin-bottom: 12px; font-family: var(--font-display); line-height: 1.4; }
  .card-desc { font-size: 12.5px; color: var(--dim); line-height: 1.55; margin-bottom: 15px; flex-grow: 1; }

  .card-footer { margin-top: auto; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--line); padding-top: 14px; }
  .card-cat { font-family: var(--font-mono); font-size: 10.5px; color: var(--gold); font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
  .card-detail { font-size: 11px; color: var(--dim); }

  .action-buttons-float { position: absolute; top: 12px; right: 12px; display: flex; gap: 8px; z-index: 10; opacity: 0; transition: 0.25s; }
  .card-item:hover .action-buttons-float { opacity: 1; }
  .btn-float { width: 34px; height: 34px; border-radius: 9px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 15px; color: #fff; text-decoration: none; backdrop-filter: blur(4px); transition: 0.2s; }
  .btn-float-edit { background: rgba(76,111,255,0.92); }
  .btn-float-edit:hover { background: var(--primary); transform: scale(1.08); }
  .btn-float-delete { background: rgba(242,84,91,0.92); }
  .btn-float-delete:hover { background: var(--danger); transform: scale(1.08); }

  .card-form { background: var(--panel); border: 1px solid var(--line); border-radius: 18px; padding: 32px; margin-bottom: 36px; box-shadow: 0 20px 40px -28px rgba(0,0,0,0.6); }
  .form-title { font-size: 15px; color: #fff; margin-bottom: 24px; display: flex; align-items: center; gap: 8px; font-weight: 700; font-family: var(--font-display); }
  .form-title i { color: var(--primary); font-size: 19px; }
  .form-group { margin-bottom: 20px; }
  label { font-family: var(--font-mono); font-size: 10.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: var(--dim); display: block; margin-bottom: 10px; }

  input[type=text], textarea { width: 100%; padding: 14px 15px; background: var(--bg); border: 1px solid var(--line); border-radius: 11px; color: #fff; font-size: 13.5px; transition: all 0.2s; font-family: 'Inter', sans-serif; }
  input[type=text]:focus, textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(76,111,255,0.15); }
  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }
  @media (max-width: 600px) { .grid2 { grid-template-columns: 1fr; } }

  .upload-area { border: 1.5px dashed rgba(76,111,255,0.35); border-radius: 14px; padding: 36px 20px; text-align: center; cursor: pointer; transition: 0.25s; background: rgba(76,111,255,0.02); display: block; }
  .upload-area:hover { border-color: var(--primary); background: rgba(76,111,255,0.06); }
  .upload-area img { max-height: 170px; border-radius: 8px; display: none; margin: 0 auto 15px auto; object-fit: contain; }
  .upload-text i { font-size: 42px; color: var(--primary); margin-bottom: 14px; }
  .upload-text p { font-size: 14px; color: #fff; margin: 0 0 5px 0; font-weight: 600; }
  .upload-text span { font-size: 11.5px; color: var(--dim); }

  .submit-btn { width: 100%; padding: 16px; border: none; border-radius: 12px; cursor: pointer; background: var(--primary); color: #fff; font-size: 14px; font-weight: 700; transition: all 0.25s ease; display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 8px; }
  .submit-btn:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 14px 28px -10px rgba(76,111,255,0.4); }
</style>

<div class="wrap-form">
  <div class="header-flex">
    <div>
      <h1>Latar Belakang Skill</h1>
      <p>Kelola gambar dan data skill yang tampil di halaman depan.</p>
    </div>
    <a href="{{ route('portofolio.index') }}#LatarBelakangSkill" target="_blank" class="btn-outline">
      <i class='bx bx-link-external'></i> Lihat Website
    </a>
  </div>

  @if (session('success_msg'))
    <div class="alert-succ"><i class='bx bx-check-circle' style="font-size: 18px;"></i> <span>{{ session('success_msg') }}</span></div>
  @endif

  <!-- SUDAH DIUBAH KE admin.latar_belakang.header -->
  <form action="{{ route('admin.latar_belakang.header') }}" method="POST">
    @csrf
    <div class="card-form" style="margin-bottom: 36px;">
      <div class="form-title" style="color: var(--cyan);"><i class='bx bx-edit' style="color:var(--cyan);"></i> Panel Latar Belakang Skill (Utama)</div>

      <div class="grid2 form-group">
        <div>
          <label>TAG KECIL (KIRI ATAS)</label>
          <input type="text" name="skill_tag" value="{{ $profile->about_sub_3 ?: '02 / LATAR BELAKANG SKILL' }}" required>
        </div>
        <div>
          <label>JUDUL UTAMA (KIRI BAWAH)</label>
          <input type="text" name="skill_title" value="{{ $profile->about_sub_2 ?: 'LATAR BELAKANG SKILL' }}" required>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 0;">
        <label>DESKRIPSI UTAMA (SEBELAH KANAN)</label>
        <textarea name="skill_desc" rows="3" required style="resize: vertical;">{{ $profile->about_2 ?: 'Dokumentasi kegiatan pemrograman web, desain UI/UX, dan organisasi sosial.' }}</textarea>
      </div>

      <button type="submit" class="submit-btn" style="margin-top: 15px;"><i class='bx bx-save'></i> Simpan Perubahan Utama</button>
    </div>
  </form>

  <div>
    <h3 style="font-size: 16px; margin-bottom: 5px; color: #fff; font-family: var(--font-display); font-weight:700;">
        <i class='bx bx-grid-alt' style="color: var(--primary); margin-right: 5px;"></i> Data yang sudah ada
    </h3>
    <p style="font-size: 12.5px; color: var(--dim);">Arahkan kursor ke kartu untuk <strong>Edit Gambar/Teks</strong> atau <strong>Menghapus</strong>.</p>

    <div class="skill-grid">
        @if(isset($dataKeahlian))
            @foreach($dataKeahlian as $item)
            <div class="card-item">
                <div class="action-buttons-float">
                    <!-- SUDAH DIUBAH KE admin.latar_belakang.edit -->
                    <a href="{{ route('admin.latar_belakang.edit', $item->id) }}" class="btn-float btn-float-edit" title="Edit Kartu Ini">
                        <i class='bx bx-edit'></i>
                    </a>
                    <!-- SUDAH DIUBAH KE admin.latar_belakang.delete -->
                    <form action="{{ route('admin.latar_belakang.delete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kartu ini?');" style="margin: 0;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-float btn-float-delete" title="Hapus Kartu">
                            <i class='bx bx-trash'></i>
                        </button>
                    </form>
                </div>

                <div class="card-image-wrap">
                    @if(!empty($item->gambar) && file_exists(public_path('uploads/' . $item->gambar)))
                        <img src="{{ asset('uploads/'.$item->gambar) }}" alt="Skill Image">
                    @else
                        <div class="no-img-text"><i class='bx bx-image-alt'></i> Belum Ada Gambar (Klik Edit)</div>
                    @endif
                </div>

                <div class="card-content">
                    <div class="card-module">{{ $item->modul }}</div>
                    <div class="card-title">{{ $item->judul }}</div>

                    <div class="card-desc">
                        {{ \Illuminate\Support\Str::limit($item->deskripsi, 80, '...') }}
                    </div>

                    <div class="card-footer">
                        <span class="card-cat">{{ $item->kategori }}</span>
                        <!-- SUDAH DIUBAH KE admin.latar_belakang.edit -->
                        <a href="{{ route('admin.latar_belakang.edit', $item->id) }}" class="card-detail" style="text-decoration: none; transition: 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--dim)'">Klik detail &rarr;</a>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
  </div>

  <!-- SUDAH DIUBAH KE admin.latar_belakang.store -->
  <form action="{{ route('admin.latar_belakang.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-form">
      <div class="form-title"><i class='bx bx-plus-circle'></i> Tambah Item Baru</div>

      <div class="form-group">
        <label>Gambar Ilustrasi</label>
        <label class="upload-area" id="upload-area">
            <img id="preview-img" src="">
            <div class="upload-text" id="upload-text">
                <i class='bx bx-cloud-upload'></i>
                <p>KLIK UNTUK MEMILIH GAMBAR</p>
                <span>FORMAT: JPG/PNG, MAKS: 2MB</span>
            </div>
            <input type="file" name="gambar" accept="image/*" required style="display: none;" onchange="previewFile(this)">
        </label>
      </div>

      <div class="grid2 form-group">
        <div>
          <label>Teks Modul Atas</label>
          <input type="text" name="modul" placeholder="Contoh: MODULE / 01" required>
        </div>
        <div>
          <label>Kategori Bawah</label>
          <input type="text" name="kategori" placeholder="Contoh: DEVELOPMENT" required>
        </div>
      </div>

      <div class="form-group">
        <label>Judul Utama</label>
        <input type="text" name="judul" placeholder="Contoh: Pemrograman Web & Laravel" required>
      </div>

      <div class="form-group">
        <label>Deskripsi Panjang (Muncul di Pop-up Website)</label>
        <textarea name="deskripsi" rows="4" placeholder="Tuliskan penjelasan detail tentang modul ini di sini..." required style="resize: vertical;"></textarea>
      </div>

      <button type="submit" class="submit-btn"><i class='bx bx-save' style="font-size: 18px;"></i> Simpan Data Baru</button>
    </div>
  </form>

</div>

<script>
    function previewFile(input) {
        var file = input.files[0];
        if(file){
            var reader = new FileReader();
            reader.onload = function(e){
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('preview-img').style.display = 'block';
                document.getElementById('upload-text').style.display = 'none';
                document.getElementById('upload-area').style.borderColor = 'var(--primary)';
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection