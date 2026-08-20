@extends('portfolio.admin_layout')
@section('title', 'Kelola Tentang Saya')

@section('content')
<style>
  /* ========================================= */
  /* CSS PREMIUM UNTUK HALAMAN ADMIN ABOUT     */
  /* ========================================= */
  .wrap-form { max-width: 800px; }
  .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
  
  .btn-outline { padding: 10px 18px; border: 1px solid var(--line); border-radius: 10px; font-size: 13px; color: var(--text); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; font-weight: 500; }
  .btn-outline:hover { border-color: var(--primary); color: var(--primary); background: rgba(55,99,224,0.1); }

  .alert-succ { background:rgba(46,213,115,0.1); border:1px solid rgba(46,213,115,0.3); color:#2ed573; padding: 14px 16px; border-radius: 12px; font-size: 13px; display: flex; align-items: center; gap: 10px; margin-bottom: 24px; font-weight: 500; }

  .card-form { background: var(--panel); border: 1px solid var(--line); border-radius: 16px; padding: 30px; margin-bottom: 24px; transition: 0.3s; }
  .card-form:hover { border-color: rgba(255, 255, 255, 0.15); }
  .card-dashed { border: 1px dashed var(--cyan); background: rgba(0, 229, 255, 0.02); }
  
  .form-group { margin-bottom: 20px; }
  label { font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--dim); display: block; margin-bottom: 8px; }
  
  input[type=text], textarea { width: 100%; padding: 14px 16px; background: var(--bg); border: 1px solid var(--line); border-radius: 10px; color: var(--text); font-size: 14px; transition: all 0.2s; font-family: 'Inter', sans-serif; }
  input[type=text]:focus, textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(55,99,224,0.15); }
  input.cyan-focus:focus, textarea.cyan-focus:focus { border-color: var(--cyan); box-shadow: 0 0 0 3px rgba(0, 229, 255, 0.15); }

  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
  @media (max-width: 600px) { .grid2 { grid-template-columns: 1fr; } }

  .submit-btn { width: 100%; padding: 16px; border: none; border-radius: 12px; cursor: pointer; background: var(--primary); color: #fff; font-size: 14px; font-weight: 600; transition: all 0.3s ease; display: flex; justify-content: center; align-items: center; gap: 8px; letter-spacing: 0.5px;}
  .submit-btn:hover { background: #2b4eb5; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(55,99,224,0.3); }
  
  .btn-add { background: var(--cyan); color: #000; }
  .btn-add:hover { background: #00e5ff; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0, 229, 255, 0.25); }

  .btn-edit { padding: 10px 16px; background: rgba(55,99,224,0.1); color: var(--primary); border: 1px solid rgba(55,99,224,0.3); border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-weight: 600; font-size: 13px; transition: 0.2s; text-decoration: none; }
  .btn-edit:hover { background: var(--primary); color: #fff; box-shadow: 0 5px 15px rgba(55,99,224,0.3); }

  .btn-delete { padding: 10px 16px; background: rgba(255, 93, 162, 0.1); color: var(--pink); border: 1px solid rgba(255, 93, 162, 0.3); border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-weight: 600; font-size: 13px; transition: 0.2s; }
  .btn-delete:hover { background: var(--pink); color: #fff; box-shadow: 0 5px 15px rgba(255, 93, 162, 0.3); }

  .list-item { background: var(--panel); border: 1px solid var(--line); border-radius: 14px; padding: 20px 24px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; transition: 0.2s; }
  .list-item:hover { transform: translateX(5px); border-color: rgba(255, 255, 255, 0.2); }
</style>

<div class="wrap-form">
  <!-- HEADER -->
  <div class="header-flex">
    <div>
      <h1 style="font-family: 'Sora', sans-serif; font-size: 28px; margin-bottom: 5px; color: #fff;">Kelola Tentang Saya</h1>
      <p style="color: var(--dim); font-size: 14px;">Atur section utama dan tambahkan panel latar belakang dengan mudah.</p>
    </div>
    <a href="{{ route('portofolio.index') }}#gallery" target="_blank" class="btn-outline">
      <i class='bx bx-link-external'></i> Lihat Website
    </a>
  </div>

  @if (session('success_msg'))
    <div class="alert-succ"><i class='bx bx-check-circle' style="font-size: 18px;"></i> <span>{{ session('success_msg') }}</span></div>
  @endif

  <!-- ========================================================= -->
  <!-- BAGIAN 1: SECTION UTAMA (BAWAAN DEFAULT)                  -->
  <!-- ========================================================= -->
  <form action="{{ route('admin.about.update') }}" method="POST">
    @csrf
    <div class="card-form">
      <h3 style="color: var(--primary); margin-bottom: 24px; font-size: 15px; display: flex; align-items: center; gap: 8px;">
        <i class='bx bx-edit-alt' style="font-size: 20px;"></i> Panel Tentang Saya (Utama)
      </h3>
      
      <div class="grid2 form-group">
        <div>
          <label>Tag Kecil (Kiri Atas)</label>
          <input type="text" name="about_sub_1" value="{{ $profile->about_sub_1 ?? '01 / TENTANG SAYA' }}" required placeholder="01 / TENTANG SAYA">
        </div>
        <div>
          <label>Judul Utama (Kiri Bawah)</label>
          <input type="text" name="about_title" value="{{ $profile->about_title ?? '' }}" placeholder="Contoh: Membangun Solusi Digital..." required>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 0;">
        <label>Deskripsi Utama (Sebelah Kanan)</label>
        <textarea name="about_1" rows="5" required placeholder="Tuliskan deskripsi lengkapmu di sini...">{{ $profile->about_1 ?? '' }}</textarea>
      </div>
    </div>

    <!-- Hidden inputs to prevent null errors from controller -->
    <input type="hidden" name="about_2" value="">
    <input type="hidden" name="about_sub_2" value="">
    <input type="hidden" name="about_3" value="">
    <input type="hidden" name="about_sub_3" value="">

    <button type="submit" class="submit-btn">
      <i class='bx bx-save' style="font-size: 18px;"></i> Simpan Perubahan Utama
    </button>
  </form>

  <hr style="border-top: 2px dashed var(--line); border-bottom: none; border-left: none; border-right: none; margin: 50px 0;">

  <!-- ========================================================= -->
  <!-- BAGIAN 2: TOMBOL TAMBAH PANEL BARU (TAK TERBATAS)         -->
  <!-- ========================================================= -->
  <div style="margin-bottom: 24px;">
    <h2 style="font-family: 'Sora', sans-serif; font-size: 22px; color: #fff; margin-bottom: 6px;">Tambah Section Baru</h2>
    <p style="color: var(--dim); font-size: 13px;">Isi form ini untuk menambah blok baru (1 Judul + 1 Deskripsi) ke halaman depan.</p>
  </div>

  <form action="{{ route('admin.panels.store') }}" method="POST">
    @csrf
    <div class="card-form card-dashed">
      <div class="grid2 form-group">
        <div>
          <label>Tag Kecil Atas</label>
          <input type="text" name="tag" class="cyan-focus" placeholder="Contoh: 01.5 / PENGALAMAN KERJA" required>
        </div>
        <div>
          <label>Judul Utama (Kiri)</label>
          <input type="text" name="title" class="cyan-focus" placeholder="Contoh: Pengalaman Industri" required>
        </div>
      </div>

      <div class="form-group">
        <label>Deskripsi Panjang (Kanan)</label>
        <textarea name="desc_1" class="cyan-focus" rows="4" required placeholder="Tuliskan deskripsi untuk section ini..."></textarea>
      </div>

      <button type="submit" class="submit-btn btn-add">
        <i class='bx bx-layer-plus' style="font-size: 18px;"></i> Tambahkan Section Ke Website
      </button>
    </div>
  </form>

  <!-- ========================================================= -->
  <!-- LIST SECTION YANG UDAH DIBIKIN (BISA DIEDIT & DIHAPUS)    -->
  <!-- ========================================================= -->
  <div style="margin-top: 40px;">
    <h3 style="font-size: 15px; margin-bottom: 20px; color: var(--text); display: flex; align-items: center; gap: 8px;">
      <i class='bx bx-list-ul' style="color: var(--cyan); font-size: 20px;"></i> Section yang telah ditambahkan:
    </h3>
    
    @if(isset($panels) && $panels->isEmpty())
      <div style="text-align: center; padding: 40px; background: rgba(255,255,255,0.02); border: 1px dashed var(--line); border-radius: 14px;">
        <i class='bx bx-ghost' style="font-size: 40px; color: var(--dim); margin-bottom: 10px;"></i>
        <p style="color: var(--dim); font-size: 13px; font-style: italic;">Belum ada section tambahan yang dibuat.</p>
      </div>
    @endif

    @if(isset($panels))
      @foreach($panels as $panel)
      <div class="list-item">
        <div>
          <span style="font-size: 11px; font-weight: 600; color: var(--cyan); font-family: monospace; letter-spacing: 1px; text-transform: uppercase;">{{ $panel->tag }}</span>
          <h4 style="color: #fff; margin-top: 6px; font-size: 18px; font-family: 'Sora', sans-serif;">{{ $panel->title }}</h4>
        </div>
        
        <!-- BUNGKUS TOMBOL EDIT & HAPUS -->
        <div style="display: flex; gap: 8px; align-items: center;">
            <a href="{{ route('admin.panels.edit', $panel->id) }}" class="btn-edit">
                <i class='bx bx-edit'></i> Edit
            </a>

            <form action="{{ route('admin.panels.delete', $panel->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus section ini dari website?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-delete">
                <i class='bx bx-trash'></i> Hapus
              </button>
            </form>
        </div>
      </div>
      @endforeach
    @endif
  </div>
</div>
@endsection