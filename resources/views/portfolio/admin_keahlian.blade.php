@extends('portfolio.admin_layout')
@section('title', 'Kelola Latar Belakang Skill')

@section('content')
<style>
  .wrap-form { max-width: 1000px; margin: 0 auto; }
  .header-flex { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 35px; }
  .btn-outline { padding: 10px 18px; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; font-size: 13px; color: var(--text); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; font-weight: 500; background: rgba(255,255,255,0.02); }
  .btn-outline:hover { border-color: var(--primary); color: #fff; background: rgba(55,99,224,0.1); transform: translateY(-2px); }
  .alert-succ { background:rgba(46,213,115,0.1); border:1px solid rgba(46,213,115,0.3); color:#2ed573; padding: 16px 20px; border-radius: 12px; font-size: 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 24px; font-weight: 500; }

  /* Grid Kartu Preview Admin */
  .skill-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; margin-top: 15px; margin-bottom: 50px; }
  .card-item { background: #151a24; border: 1px solid rgba(255,255,255,0.05); border-radius: 18px; overflow: hidden; position: relative; transition: 0.3s; box-shadow: 0 5px 20px rgba(0,0,0,0.2); display: flex; flex-direction: column; }
  .card-item:hover { transform: translateY(-5px); border-color: rgba(255, 171, 0, 0.3); }
  
  .card-image-wrap { position: relative; width: 100%; height: 180px; overflow: hidden; background: #0e121a; display: flex; align-items: center; justify-content: center; }
  .card-image-wrap img { width: 100%; height: 100%; object-fit: cover; }
  .no-img-text { color: var(--dim); font-size: 12px; font-style: italic; display: flex; align-items: center; gap: 6px; }
  
  .card-content { padding: 20px; flex: 1; display: flex; flex-direction: column; }
  .card-module { font-size: 10px; color: var(--dim); letter-spacing: 1.5px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; }
  .card-title { font-size: 18px; color: #fff; font-weight: 700; margin-bottom: 12px; font-family: 'Sora', sans-serif; line-height: 1.4; }
  
  /* Style untuk Deskripsi di Preview Admin */
  .card-desc { font-size: 12.5px; color: var(--dim); line-height: 1.5; margin-bottom: 15px; flex-grow: 1; }

  .card-footer { margin-top: auto; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 15px; }
  .card-cat { font-size: 11px; color: #ffab00; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
  .card-detail { font-size: 11px; color: var(--dim); }

  /* Tombol Action Aksen Atas Kartu */
  .action-buttons-float { position: absolute; top: 12px; right: 12px; display: flex; gap: 8px; z-index: 10; opacity: 0; transition: 0.3s; }
  .card-item:hover .action-buttons-float { opacity: 1; }
  .btn-float { width: 36px; height: 36px; border-radius: 10px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #fff; text-decoration: none; backdrop-filter: blur(4px); transition: 0.2s; }
  .btn-float-edit { background: rgba(55, 99, 224, 0.9); }
  .btn-float-edit:hover { background: var(--primary); transform: scale(1.1); }
  .btn-float-delete { background: rgba(255, 93, 162, 0.9); }
  .btn-float-delete:hover { background: #ff1744; transform: scale(1.1); }

  /* Form Tambah Item */
  .card-form { background: var(--panel); border: 1px solid rgba(55, 99, 224, 0.2); border-radius: 16px; padding: 35px; margin-bottom: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
  .form-title { font-size: 16px; color: #fff; margin-bottom: 25px; display: flex; align-items: center; gap: 8px; font-weight: 600; }
  .form-title i { color: var(--primary); font-size: 20px; }
  .form-group { margin-bottom: 20px; }
  label { font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--dim); display: block; margin-bottom: 10px; }
  
  input[type=text], textarea { width: 100%; padding: 16px; background: rgba(0,0,0,0.2); border: 1px solid var(--line); border-radius: 12px; color: #fff; font-size: 14px; transition: all 0.2s; font-family: 'Inter', sans-serif; }
  input[type=text]:focus, textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(55,99,224,0.15); background: rgba(0,0,0,0.3); }
  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
  @media (max-width: 600px) { .grid2 { grid-template-columns: 1fr; } }
  
  .upload-area { border: 2px dashed rgba(55,99,224,0.3); border-radius: 14px; padding: 40px 20px; text-align: center; cursor: pointer; transition: 0.3s; background: rgba(55,99,224,0.02); display: block; }
  .upload-area:hover { border-color: var(--primary); background: rgba(55,99,224,0.05); }
  .upload-area img { max-height: 180px; border-radius: 8px; display: none; margin: 0 auto 15px auto; object-fit: contain; }
  .upload-text i { font-size: 48px; color: var(--primary); margin-bottom: 15px; }
  .upload-text p { font-size: 15px; color: #fff; margin: 0 0 5px 0; font-weight: 600; }
  .upload-text span { font-size: 12px; color: var(--dim); }

  .submit-btn { width: 100%; padding: 18px; border: none; border-radius: 12px; cursor: pointer; background: var(--primary); color: #fff; font-size: 15px; font-weight: 700; transition: all 0.3s ease; display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 10px; }
  .submit-btn:hover { background: #2b4eb5; transform: translateY(-3px); box-shadow: 0 10px 25px rgba(55,99,224,0.3); }
</style>

<div class="wrap-form">
  <div class="header-flex">
    <div>
      <h1 style="font-family: 'Sora', sans-serif; font-size: 32px; margin-bottom: 5px; color: #fff;">Latar Belakang Skill</h1>
      <p style="color: var(--dim); font-size: 14px;">Kelola gambar dan data skill yang tampil di halaman depan.</p>
    </div>
    <a href="{{ route('portofolio.index') }}#LatarBelakangSkill" target="_blank" class="btn-outline">
      <i class='bx bx-link-external'></i> Lihat Website
    </a>
  </div>

  @if (session('success_msg'))
    <div class="alert-succ"><i class='bx bx-check-circle' style="font-size: 20px;"></i> <span>{{ session('success_msg') }}</span></div>
  @endif

  <!-- BAGIAN ATAS: DAFTAR KARTU -->
  <div>
    <h3 style="font-size: 18px; margin-bottom: 5px; color: #fff; font-family: 'Sora', sans-serif;">
        <i class='bx bx-grid-alt' style="color: var(--primary); margin-right: 5px;"></i> Data yang sudah ada
    </h3>
    <p style="font-size: 13px; color: var(--dim);">Arahkan kursor ke kartu untuk **Edit Gambar/Teks** atau **Menghapus**.</p>

    <div class="skill-grid">
        @if(isset($dataKeahlian))
            @foreach($dataKeahlian as $item)
            <div class="card-item">
                <!-- Tombol Action Melayang saat Hover -->
                <div class="action-buttons-float">
                    <a href="{{ route('admin.keahlian.edit', $item->id) }}" class="btn-float btn-float-edit" title="Edit Kartu Ini">
                        <i class='bx bx-edit'></i>
                    </a>
                    <form action="{{ route('admin.keahlian.delete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kartu ini?');" style="margin: 0;">
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
                    
                    <!-- INI DIA DESKRIPSI SINGKATNYA YANG BARU DITAMBAH -->
                    <div class="card-desc">
                        {{ \Illuminate\Support\Str::limit($item->deskripsi, 80, '...') }}
                    </div>

                    <div class="card-footer">
                        <span class="card-cat">{{ $item->kategori }}</span>
                        <span class="card-detail">Klik detail &rarr;</span>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
  </div>

  <!-- BAGIAN BAWAH: FORM TAMBAH BARU -->
  <form action="{{ route('admin.keahlian.store') }}" method="POST" enctype="multipart/form-data">
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

      <button type="submit" class="submit-btn"><i class='bx bx-save' style="font-size: 20px;"></i> Simpan Data Baru</button>
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