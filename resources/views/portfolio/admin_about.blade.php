@extends('portfolio.admin_layout')
@section('title', 'Kelola Tentang Saya')

@section('content')
<div class="wrap-form" style="max-width: 800px;">
  <div class="header-flex">
    <div>
      <h1>Kelola Tentang Saya</h1>
      <p>Atur section utama dan tambahkan panel latar belakang dengan mudah.</p>
    </div>
    <a href="{{ route('portofolio.index') }}#gallery" target="_blank" class="btn-outline">
      <i class='bx bx-link-external'></i> Lihat Website
    </a>
  </div>

  @if (session('success_msg'))
    <div class="alert-succ"><i class='bx bx-check-circle' style="font-size: 18px;"></i> <span>{{ session('success_msg') }}</span></div>
  @endif

  <form action="{{ route('admin.about.update') }}" method="POST">
    @csrf
    <div class="card-form">
      <div class="form-title"><i class='bx bx-edit-alt'></i>Tentang Saya</div>

      <div class="grid2 form-group">
        <div>
          <label>Tag Kecil (Kiri Atas)</label>
          <!-- Menggunakan ?: agar kebal dari database kosong -->
          <input type="text" name="about_sub_1" value="{{ $about->tag ?: '01 / TENTANG SAYA' }}" required placeholder="01 / TENTANG SAYA">
        </div>

        <div>
          <label>Judul Utama (Kiri Bawah)</label>
          <input type="text" name="about_title" value="{{ $about->title ?: 'Membangun Solusi Digital dengan Logika & Kreativitas' }}" placeholder="Contoh: Membangun Solusi Digital..." required>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 0;">
        <label>Deskripsi Utama (Sebelah Kanan)</label>
        <textarea name="about_1" rows="5" required placeholder="Tuliskan deskripsi lengkapmu di sini...">{{ $about->description ?: 'Siswa kelas 12 IT Engineering dengan minat mendalam di bidang pengembangan web dan desain UI/UX. Aktif berorganisasi sebagai Sekretaris Umum OSIS dan Ketua Karang Taruna untuk mengasah kepemimpinan, manajemen tim, dan komunikasi.' }}</textarea>
      </div>
    </div>

    <button type="submit" class="submit-btn">
      <i class='bx bx-save'></i> Simpan Perubahan Utama
    </button>
  </form>

  <hr class="section-divider">

  <div style="margin-bottom: 22px;">
    <h2 class="section-heading">Tambah Section Baru</h2>
    <p class="section-subheading">Isi form ini untuk menambah blok baru.</p>
  </div>

  <form action="{{ route('admin.panels.store') }}" method="POST">
    @csrf
    <div class="card-form dashed" style="--accent: var(--cyan);">
      <div class="grid2 form-group">
        <div>
          <label>Tag Kecil Atas</label>
          <input type="text" name="tag" placeholder="Contoh: Nomor 01.5 " required>
        </div>
        <div>
          <label>Judul Utama (Kiri)</label>
          <input type="text" name="title" placeholder="Contoh: Pengalaman Industri" required>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 0;">
        <label>Deskripsi Panjang</label>
        <textarea name="desc_1" rows="4" placeholder="Contoh: Selama 3 tahun terakhir, saya aktif dalam berbagai kepanitiaan dan..." required></textarea>
      </div>
    </div>

    <button type="submit" class="submit-btn accent-cyan">
      <i class='bx bx-layer-plus'></i> Menambahkan Ke Website
    </button>
  </form>

  <div style="margin-top: 36px;">
    <h3 style="font-size: 14px; margin-bottom: 18px; color: var(--text); display: flex; align-items: center; gap: 8px; font-weight: 600;">
      <i class='bx bx-list-ul' style="color: var(--cyan); font-size: 19px;"></i>
       telah ditambahkan
    </h3>

    @if(isset($panels) && $panels->isEmpty())
      <div class="empty-state">
        <i class='bx bx-ghost'></i>
        <p>Belum ada yang tambahan.</p>
      </div>
    @endif

    @if(isset($panels))
      @foreach($panels as $panel)
      <div class="list-item">
        <div>
          <span style="font-family: var(--font-mono); font-size: 10.5px; font-weight: 600; color: var(--cyan); letter-spacing: 1px; text-transform: uppercase;">{{ $panel->tag }}</span>
          <h4 style="color: #fff; margin-top: 6px; font-size: 17px; font-family: var(--font-display); font-weight: 700;">{{ $panel->title }}</h4>
        </div>

        <div style="display: flex; gap: 8px; align-items: center;">
            <a href="{{ route('admin.panels.edit', $panel->id) }}" class="btn-edit">
                <i class='bx bx-edit'></i> Edit
            </a>

            <form id="delete-form-{{ $panel->id }}" action="{{ route('admin.panels.delete', $panel->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="button" class="btn-delete" onclick="hapusPanel('delete-form-{{ $panel->id }}')">
                <i class='bx bx-trash'></i> Hapus
              </button>
            </form>
        </div>
      </div>
      @endforeach
    @endif
  </div>
</div>

<!-- SweetAlert2 Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function hapusPanel(formId) {
    Swal.fire({
      title: 'Hapus section ini?',
      text: "Data akan dihapus permanen.",
      icon: 'warning',
      width: '340px',
      padding: '1.5em',
      showCancelButton: true,
      reverseButtons: true,
      confirmButtonColor: '#ff4757', 
      cancelButtonColor: '#2b303b',  
      confirmButtonText: 'Hapus',
      cancelButtonText: 'Batal',
      background: '#1a1d27',         
      color: '#ffffff',              
      customClass: {
        popup: 'swal-custom-border',
      }
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById(formId).submit();
      }
    })
  }
</script>

<style>
  .swal-custom-border {
    border-radius: 16px !important;
    border: 1px solid rgba(255, 255, 255, 0.05);
  }
</style>
@endsection