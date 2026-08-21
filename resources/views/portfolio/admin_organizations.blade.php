@extends('portfolio.admin_layout')
@section('title', 'Kelola Organisasi')

@section('content')
<style>
  .wrap-form { max-width: 950px; margin: 0 auto; }
  .header-flex { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 35px; }
  .btn-outline { padding: 10px 18px; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; font-size: 13px; color: var(--text); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; font-weight: 500; background: rgba(255,255,255,0.02); }
  .btn-outline:hover { border-color: var(--primary); color: #fff; background: rgba(55,99,224,0.1); }
  .alert-succ { background:rgba(46,213,115,0.1); border:1px solid rgba(46,213,115,0.3); color:#2ed573; padding: 16px 20px; border-radius: 12px; font-size: 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 24px; font-weight: 500; }
  
  .card-form { background: var(--panel); border: 1px solid rgba(55, 99, 224, 0.2); border-radius: 16px; padding: 35px; margin-bottom: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
  .form-title { font-size: 16px; color: #fff; margin-bottom: 25px; display: flex; align-items: center; gap: 8px; font-weight: 600; }
  
  label { font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--dim); display: block; margin-bottom: 8px; }
  input[type=text], textarea { width: 100%; padding: 14px; background: rgba(0,0,0,0.2); border: 1px solid var(--line); border-radius: 10px; color: #fff; font-size: 13px; transition: all 0.2s; font-family: 'Inter', sans-serif; }
  input[type=text]:focus, textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(55,99,224,0.15); background: rgba(0,0,0,0.3); }
  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
  
  .submit-btn { width: 100%; padding: 18px; border: none; border-radius: 12px; cursor: pointer; background: var(--primary); color: #fff; font-size: 15px; font-weight: 700; transition: all 0.3s; display: flex; justify-content: center; align-items: center; gap: 8px; margin-top:20px; }
  .submit-btn:hover { background: #2b4eb5; transform: translateY(-3px); box-shadow: 0 10px 25px rgba(55,99,224,0.3); }

  /* Style Kotak Organisasi */
  .org-row { background: rgba(0,0,0,0.2); padding: 25px; border-radius: 12px; border: 1px solid var(--line); margin-bottom: 20px; transition: 0.3s; position: relative; }
  .org-row:hover { border-color: var(--primary); }
  .grid3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px; }
  
  .btn-remove { position: absolute; top: 20px; right: 20px; background: rgba(255, 93, 162, 0.1); color: #ff1744; border: 1px solid rgba(255, 93, 162, 0.3); width: 35px; height: 35px; border-radius: 8px; cursor: pointer; transition: 0.2s; display: flex; align-items: center; justify-content: center; font-size: 18px; }
  .btn-remove:hover { background: #ff1744; color: #fff; }
  .btn-add { background: rgba(78, 225, 214, 0.1); color: #4facfe; border: 1px dashed #4facfe; width: 100%; padding: 15px; border-radius: 12px; cursor: pointer; font-family: 'Inter'; font-weight: 600; font-size: 14px; transition: 0.2s; display: flex; justify-content: center; align-items: center; gap: 8px;}
  .btn-add:hover { background: #4facfe; color: #000; }
</style>

<div class="wrap-form">
  <div class="header-flex">
    <div>
      <h1 style="font-family: 'Sora', sans-serif; font-size: 32px; margin-bottom: 5px; color: #fff;">Pengalaman Organisasi</h1>
      <p style="color: var(--dim); font-size: 14px;">Atur jejak kepemimpinanmu di sini. Data akan tampil dengan gaya Zigzag!</p>
    </div>
    <a href="{{ route('portofolio.index') }}#organization" target="_blank" class="btn-outline">
      <i class='bx bx-link-external'></i> Lihat Website
    </a>
  </div>

  @if (session('success_msg'))
    <div class="alert-succ"><i class='bx bx-check-circle' style="font-size: 20px;"></i> <span>{{ session('success_msg') }}</span></div>
  @endif

  <form action="{{ route('admin.organizations.update') }}" method="POST" id="mainForm" onsubmit="prepareData(event)">
    @csrf
    <input type="hidden" name="experiences_data" id="experiences_data">
    
    <!-- BAGIAN 1: TEKS HEADER ORGANISASI -->
    <div class="card-form">
      <div class="form-title" style="color: #4facfe;"><i class='bx bx-text'></i> Teks Judul (Header)</div>
      <div class="grid2 form-group">
        <div>
          <label>Tag (Kiri Atas)</label>
          <input type="text" name="org_tag" value="{{ $header['tag'] }}" required>
        </div>
        <div>
          <label>Judul Utama</label>
          <input type="text" name="org_title" value="{{ $header['title'] }}" required>
        </div>
      </div>
      <div class="form-group" style="margin-bottom: 0;">
        <label>Deskripsi Singkat</label>
        <textarea name="org_desc" rows="2" required>{{ $header['desc'] }}</textarea>
      </div>
    </div>
    
    <!-- BAGIAN 2: DAFTAR ORGANISASI -->
    <div class="card-form" style="border-color: rgba(78, 225, 214, 0.3);">
      <div class="form-title" style="color: #4facfe;">
        <i class='bx bx-git-branch'></i> Daftar Jejak Kepemimpinan
      </div>
      
      <div id="org-container">
        <!-- JS Render Masuk Sini -->
      </div>

      <button type="button" class="btn-add" onclick="addOrgRow()">
        <i class="fas fa-plus-circle"></i> Tambah Organisasi Baru
      </button>
    </div>

    <button type="submit" class="submit-btn"><i class='bx bx-save'></i> Simpan Perubahan</button>
  </form>
</div>

<script>
  let orgData = {!! $experiencesJson !!};
  const container = document.getElementById('org-container');

  function renderOrgs() {
    container.innerHTML = '';
    orgData.forEach((org, index) => {
      const row = document.createElement('div');
      row.className = 'org-row';
      row.innerHTML = `
        <button type="button" class="btn-remove" onclick="removeOrgRow(${index})" title="Hapus"><i class='bx bx-trash'></i></button>
        <div class="grid3">
          <div>
            <label>POSISI JABATAN</label>
            <input type="text" value="${org.posisi || ''}" onchange="updateData(${index}, 'posisi', this.value)" placeholder="ex: Ketua Karang Taruna" required>
          </div>
          <div>
            <label>NAMA INSTANSI / TEMPAT</label>
            <input type="text" value="${org.instansi || ''}" onchange="updateData(${index}, 'instansi', this.value)" placeholder="ex: Menganti, Gresik" required>
          </div>
          <div>
            <label>PERIODE / TAHUN</label>
            <input type="text" value="${org.periode || ''}" onchange="updateData(${index}, 'periode', this.value)" placeholder="ex: 2024 - 2026" required>
          </div>
        </div>
        <div>
          <label>DESKRIPSI TUGAS</label>
          <textarea rows="3" onchange="updateData(${index}, 'deskripsi', this.value)" placeholder="Tuliskan tugas dan pencapaianmu di sini..." required>${org.deskripsi || ''}</textarea>
        </div>
      `;
      container.appendChild(row);
    });
  }

  function updateData(index, key, value) {
    orgData[index][key] = value;
  }

  function addOrgRow() {
    orgData.push({ posisi: '', instansi: '', periode: '', deskripsi: '' });
    renderOrgs();
  }

  function removeOrgRow(index) {
    orgData.splice(index, 1);
    renderOrgs();
  }

  function prepareData(e) {
    document.getElementById('experiences_data').value = JSON.stringify(orgData);
  }

  renderOrgs();
</script>
@endsection