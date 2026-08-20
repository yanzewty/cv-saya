@extends('portfolio.admin_layout')
@section('title', 'Edit Latar Belakang Skill')

@section('content')
<!-- TAMBAHKAN LIBRARY CROPPER.JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<style>
  .wrap-form { max-width: 850px; margin: 0 auto; }
  .btn-outline { padding: 10px 18px; border: 1px solid var(--line); border-radius: 10px; font-size: 13px; color: var(--text); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-weight: 500; cursor: pointer; background: transparent; }
  .btn-outline:hover { background: rgba(255,255,255,0.05); color: #fff; border-color: var(--dim); }

  .badge-edit { background: rgba(255, 171, 0, 0.15); color: #ffab00; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; letter-spacing: 1px; display: inline-flex; align-items: center; gap: 5px; border: 1px solid rgba(255, 171, 0, 0.3); text-transform: uppercase; }

  .editor-card { background: var(--panel); border: 1px solid rgba(255, 171, 0, 0.3); border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
  .editor-body { padding: 35px; }
  
  .form-group { margin-bottom: 24px; }
  label { font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--dim); display: block; margin-bottom: 10px; }
  
  input[type=text], textarea { width: 100%; padding: 16px; background: rgba(0,0,0,0.2); border: 1px solid var(--line); border-radius: 10px; color: #fff; font-size: 14px; transition: all 0.2s; font-family: 'Inter', sans-serif; }
  input[type=text]:focus, textarea:focus { outline: none; border-color: #ffab00; box-shadow: 0 0 0 3px rgba(255, 171, 0, 0.15); background: rgba(0,0,0,0.4); }

  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
  @media (max-width: 600px) { .grid2 { grid-template-columns: 1fr; } }

  .current-img-preview { width: 100%; max-height: 250px; object-fit: cover; border-radius: 12px; border: 1px solid var(--line); margin-bottom: 15px; }
  .new-img-preview { width: 100%; max-height: 250px; object-fit: cover; border-radius: 12px; border: 2px dashed #ffab00; margin-bottom: 15px; display: none; }

  .editor-footer { padding: 24px 35px; background: rgba(0,0,0,0.2); border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 12px; }
  .btn-save { padding: 14px 28px; border-radius: 10px; font-size: 14px; font-weight: 700; color: #000; background: #ffab00; border: none; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; }
  .btn-save:hover { background: #ffc400; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 171, 0, 0.2); }

  /* ==================================== */
  /* CSS UNTUK POP-UP CROPPER             */
  /* ==================================== */
  .crop-modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(5px); }
  .crop-container { background: var(--panel); padding: 25px; border-radius: 16px; width: 90%; max-width: 700px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
  .crop-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
  .crop-header h3 { color: #fff; margin: 0; font-family: 'Sora', sans-serif; font-size: 18px; }
  .img-workspace { width: 100%; max-height: 50vh; background: #000; overflow: hidden; border-radius: 10px; }
  .img-workspace img { display: block; max-width: 100%; }
  .crop-footer { display: flex; justify-content: flex-end; gap: 12px; margin-top: 20px; }
  .btn-do-crop { padding: 12px 24px; background: var(--primary); color: #fff; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-family: 'Inter', sans-serif; transition: 0.2s; }
  .btn-do-crop:hover { background: #2b4eb5; }
</style>

<div class="wrap-form">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <div>
      <a href="{{ route('admin.keahlian') }}" class="btn-outline" style="margin-bottom: 12px;"><i class='bx bx-arrow-back'></i> Kembali</a>
      <h1 style="font-family: 'Sora', sans-serif; font-size: 28px; color: #fff;">Edit Kartu Skill</h1>
    </div>
    <div class="badge-edit"><i class='bx bx-edit-alt'></i> Mode Edit Kartu #{{ $item->id }}</div>
  </div>

  <form action="{{ route('admin.keahlian.update', $item->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
    @csrf
    <div class="editor-card">
      <div class="editor-body">
        
        <!-- BAGIAN GAMBAR -->
        <div class="form-group">
          <label>Gambar Ilustrasi Saat Ini</label>
          
          @if(!empty($item->gambar) && file_exists(public_path('uploads/' . $item->gambar)))
            <img src="{{ asset('uploads/' . $item->gambar) }}" class="current-img-preview" id="old-preview">
          @else
            <div id="no-img-text" style="padding: 20px; background: rgba(255,255,255,0.02); border: 1px dashed var(--line); border-radius: 12px; color: var(--dim); font-size: 13px; font-style: italic; text-align: center; margin-bottom: 15px;">Belum ada gambar terpasang.</div>
          @endif

          <img src="" id="new-preview" class="new-img-preview">
          
          <label style="color: #ffab00;">Ganti Gambar (Bisa di-Crop & Zoom)</label>
          <input type="file" id="imageInput" accept="image/*" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px dashed var(--line); border-radius: 10px; color: var(--text);">
          
          <!-- INPUT FILE HIDDEN UNTUK MENYIMPAN HASIL CROP -->
          <input type="file" name="gambar" id="hiddenCroppedFile" style="display: none;">
        </div>

        <div class="grid2 form-group">
          <div>
            <label>Teks Modul Atas</label>
            <input type="text" name="modul" value="{{ $item->modul }}" required>
          </div>
          <div>
            <label>Kategori Bawah</label>
            <input type="text" name="kategori" value="{{ $item->kategori }}" required>
          </div>
        </div>

        <div class="form-group">
          <label>Judul Utama</label>
          <input type="text" name="judul" value="{{ $item->judul }}" required>
        </div>

        <div class="form-group" style="margin-bottom: 0;">
          <label>Deskripsi Panjang (Muncul di Pop-up Website)</label>
          <textarea name="deskripsi" rows="5" required placeholder="Tuliskan penjelasan detail tentang modul ini di sini...">{{ $item->deskripsi ?? '' }}</textarea>
        </div>

      </div>

      <div class="editor-footer">
        <a href="{{ route('admin.keahlian') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-save"><i class='bx bx-check-double' style="font-size: 18px;"></i> Terapkan Perubahan</button>
      </div>
    </div>
  </form>
</div>

<!-- ========================================== -->
<!-- MODAL CROPPER -->
<!-- ========================================== -->
<div class="crop-modal" id="cropModal">
    <div class="crop-container">
        <div class="crop-header">
            <h3><i class='bx bx-crop'></i> Sesuaikan Ukuran Gambar</h3>
            <button class="btn-outline" onclick="closeCropModal()" style="border:none; font-size:24px; padding:0; color:#fff;">&times;</button>
        </div>
        <div class="img-workspace">
            <img id="imageToCrop" src="">
        </div>
        <div class="crop-footer">
            <button class="btn-outline" onclick="closeCropModal()">Batal</button>
            <button class="btn-do-crop" onclick="cropImage()">Potong & Gunakan <i class='bx bx-check'></i></button>
        </div>
    </div>
</div>

<script>
    let cropper;
    const imageInput = document.getElementById('imageInput');
    const hiddenCroppedFile = document.getElementById('hiddenCroppedFile');
    const cropModal = document.getElementById('cropModal');
    const imageToCrop = document.getElementById('imageToCrop');
    
    // 1. Saat File Dipilih, Buka Pop-up Cropper
    imageInput.addEventListener('change', function (e) {
        let files = e.target.files;
        if (files && files.length > 0) {
            let file = files[0];
            let url = URL.createObjectURL(file);
            
            imageToCrop.src = url;
            cropModal.style.display = 'flex'; // Tampilkan Modal

            // Hancurkan cropper lama jika ada
            if (cropper) { cropper.destroy(); }
            
            // Inisialisasi Cropper.js (Rasio 16:9 agar pas bentuk kartu)
            cropper = new Cropper(imageToCrop, {
                aspectRatio: 16 / 9, 
                viewMode: 2,
                background: false,
                autoCropArea: 1,
                zoomable: true
            });
        }
    });

    // 2. Tombol Batal Crop
    function closeCropModal() {
        cropModal.style.display = 'none';
        imageInput.value = ""; // Reset file input
        if (cropper) { cropper.destroy(); cropper = null; }
    }

    // 3. Tombol Potong & Gunakan
    function cropImage() {
        if (!cropper) return;

        // Ambil hasil potongan
        cropper.getCroppedCanvas({
            width: 800, // Ukuran ideal web
            height: 450,
        }).toBlob(function (blob) {
            
            // Trik Magic: Ubah hasil crop (Blob) jadi file beneran 
            let file = new File([blob], "cropped_image.jpg", { type: "image/jpeg", lastModified: new Date().getTime() });
            
            // Masukkan file ke input tersembunyi pakai DataTransfer API
            let container = new DataTransfer();
            container.items.add(file);
            hiddenCroppedFile.files = container.files;

            // Sembunyikan gambar lama
            if(document.getElementById('old-preview')) document.getElementById('old-preview').style.display = 'none';
            if(document.getElementById('no-img-text')) document.getElementById('no-img-text').style.display = 'none';

            // Tampilkan hasil crop di UI Form
            let newPreview = document.getElementById('new-preview');
            newPreview.src = URL.createObjectURL(blob);
            newPreview.style.display = 'block';

            // Tutup pop-up
            cropModal.style.display = 'none';
            if (cropper) { cropper.destroy(); cropper = null; }
            
        }, 'image/jpeg', 0.9);
    }
</script>
@endsection