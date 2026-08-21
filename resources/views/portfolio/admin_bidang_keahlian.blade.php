@extends('portfolio.admin_layout')
@section('title', 'Kelola Bidang Keahlian')

@section('content')
<!-- Memanggil FontAwesome agar Ikon bisa tampil di Admin -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
  .wrap-form { max-width: 950px; margin: 0 auto; }
  .header-flex { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 35px; }
  .btn-outline { padding: 10px 18px; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; font-size: 13px; color: var(--text); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; font-weight: 500; background: rgba(255,255,255,0.02); }
  .btn-outline:hover { border-color: var(--primary); color: #fff; background: rgba(55,99,224,0.1); }
  .alert-succ { background:rgba(46,213,115,0.1); border:1px solid rgba(46,213,115,0.3); color:#2ed573; padding: 16px 20px; border-radius: 12px; font-size: 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 24px; font-weight: 500; }
  
  .card-form { background: var(--panel); border: 1px solid rgba(55, 99, 224, 0.2); border-radius: 16px; padding: 35px; margin-bottom: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
  .form-title { font-size: 16px; color: #fff; margin-bottom: 25px; display: flex; align-items: center; gap: 8px; font-weight: 600; }
  .form-group { margin-bottom: 20px; }
  label { font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--dim); display: block; margin-bottom: 8px; }
  
  input[type=text], textarea, select { width: 100%; padding: 16px; background: rgba(0,0,0,0.2); border: 1px solid var(--line); border-radius: 12px; color: #fff; font-size: 14px; transition: all 0.2s; font-family: 'Inter', sans-serif; appearance: none; }
  input[type=text]:focus, textarea:focus, select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(55,99,224,0.15); background: rgba(0,0,0,0.3); }
  select option { background: var(--panel-2); color: #fff; }
  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
  
  .submit-btn { width: 100%; padding: 18px; border: none; border-radius: 12px; cursor: pointer; background: var(--primary); color: #fff; font-size: 15px; font-weight: 700; transition: all 0.3s; display: flex; justify-content: center; align-items: center; gap: 8px; margin-top:20px; }
  .submit-btn:hover { background: #2b4eb5; transform: translateY(-3px); box-shadow: 0 10px 25px rgba(55,99,224,0.3); }

  /* ========================================================
     STYLE BARIS DINAMIS (DI-UPGRADE)
     ======================================================== */
  .skill-row { display: grid; grid-template-columns: 60px 1.5fr 1.5fr 130px 45px; gap: 15px; align-items: center; background: rgba(0,0,0,0.2); padding: 15px; border-radius: 12px; border: 1px solid var(--line); margin-bottom: 15px; transition: 0.3s; }
  .skill-row:hover { border-color: #ffab00; box-shadow: 0 5px 15px rgba(0,0,0,0.2); transform: translateY(-2px); }
  
  .icon-preview { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-top: 20px; transition: 0.3s; }
  
  /* Desain Color Picker Premium ala Figma */
  .color-wrapper { position: relative; width: 100%; height: 52px; background: rgba(0,0,0,0.2); border: 1px solid var(--line); border-radius: 12px; display: flex; align-items: center; padding: 0 12px; transition: 0.2s; }
  .color-wrapper:hover { border-color: var(--primary); background: rgba(0,0,0,0.3); }
  .color-dot { width: 22px; height: 22px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.2); flex-shrink: 0; }
  .color-hex { margin-left: 10px; font-family: 'JetBrains Mono', monospace; font-size: 13px; color: #fff; text-transform: uppercase; font-weight: 500; }
  .hidden-color-picker { position: absolute; inset: 0; opacity: 0; width: 100%; height: 100%; cursor: pointer; }

  .btn-remove { background: rgba(255, 93, 162, 0.1); color: #ff1744; border: 1px solid rgba(255, 93, 162, 0.3); width: 45px; height: 45px; border-radius: 10px; cursor: pointer; transition: 0.2s; display: flex; align-items: center; justify-content: center; font-size: 18px; margin-top: 18px; }
  .btn-remove:hover { background: #ff1744; color: #fff; transform: scale(1.05); }
  
  .btn-add { background: rgba(78, 225, 214, 0.1); color: #4facfe; border: 1px dashed #4facfe; width: 100%; padding: 16px; border-radius: 12px; cursor: pointer; font-family: 'Inter'; font-weight: 600; font-size: 14px; transition: 0.2s; margin-top: 10px; display: flex; justify-content: center; align-items: center; gap: 8px;}
  .btn-add:hover { background: #4facfe; color: #000; }
</style>

<div class="wrap-form">
  <div class="header-flex">
    <div>
      <h1 style="font-family: 'Sora', sans-serif; font-size: 32px; margin-bottom: 5px; color: #fff;">Bidang Keahlian</h1>
      <p style="color: var(--dim); font-size: 14px;">Tinggal pilih Icon, ketik Nama, sesuaikan Warna, lalu Simpan!</p>
    </div>
    <a href="{{ route('portofolio.index') }}#Keahlian" target="_blank" class="btn-outline">
      <i class='bx bx-link-external'></i> Lihat Website
    </a>
  </div>

  @if (session('success_msg'))
    <div class="alert-succ"><i class='bx bx-check-circle' style="font-size: 20px;"></i> <span>{{ session('success_msg') }}</span></div>
  @endif

  <!-- Form Utama -->
  <form action="{{ route('admin.bidang_keahlian.update') }}" method="POST" id="mainForm" onsubmit="prepareData(event)">
    @csrf
    <input type="hidden" name="skills_data" id="skills_data">
    
    <!-- BAGIAN 1: TEKS HEADER -->
    <div class="card-form">
      <div class="form-title" style="color: #4facfe;"><i class='bx bx-text'></i> Teks Judul (Header)</div>
      <div class="grid2 form-group">
        <div>
          <label>Tag (Kiri Atas)</label>
          <input type="text" name="skill_tag" value="{{ $header['tag'] }}" required>
        </div>
        <div>
          <label>Judul Utama</label>
          <input type="text" name="skill_title" value="{{ $header['title'] }}" required>
        </div>
      </div>
      <div class="form-group" style="margin-bottom: 0;">
        <label>Deskripsi Singkat</label>
        <textarea name="skill_desc" rows="2" required>{{ $header['desc'] }}</textarea>
      </div>
    </div>

    <!-- BAGIAN 2: KOTAK SKILL DINAMIS -->
    <div class="card-form" style="border-color: rgba(255, 171, 0, 0.3);">
      <div class="form-title" style="color: #ffab00;">
        <i class='bx bx-category'></i> Daftar Keahlian (UI Premium)
      </div>
      
      <div id="skills-container">
        <!-- JS Render Masuk Sini -->
      </div>

      <button type="button" class="btn-add" onclick="addSkillRow()">
        <i class="fas fa-plus-circle"></i> Tambah Skill Baru
      </button>
    </div>

    <button type="submit" class="submit-btn"><i class='bx bx-save'></i> Simpan Perubahan</button>
  </form>
</div>

<script>
  let skillsData = {!! $skillsJson !!};
  const container = document.getElementById('skills-container');

  // Daftar Pilihan Ikon Siap Pakai
  const iconList = [
      { val: 'fas fa-code', name: '--- Default (Code) ---' },
      { val: 'fab fa-html5', name: 'HTML5' },
      { val: 'fab fa-css3-alt', name: 'CSS3' },
      { val: 'fab fa-js', name: 'JavaScript / JS' },
      { val: 'fab fa-php', name: 'PHP' },
      { val: 'fab fa-laravel', name: 'Laravel' },
      { val: 'fab fa-react', name: 'React' },
      { val: 'fab fa-vuejs', name: 'Vue.js' },
      { val: 'fab fa-node-js', name: 'Node.js' },
      { val: 'fab fa-python', name: 'Python' },
      { val: 'fab fa-java', name: 'Java' },
      { val: 'fab fa-figma', name: 'Figma' },
      { val: 'fab fa-github', name: 'GitHub' },
      { val: 'fab fa-wordpress', name: 'WordPress' },
      { val: 'fas fa-database', name: 'Database / SQL' },
      { val: 'fas fa-paint-brush', name: 'UI / UX Design' },
      { val: 'fas fa-palette', name: 'Design / Poster / Art' },
      { val: 'fas fa-tools', name: 'Hardware / Troubleshoot' },
      { val: 'fas fa-server', name: 'Server / Jaringan' },
      { val: 'fas fa-microphone', name: 'Public Speaking' },
      { val: 'fas fa-users', name: 'Leadership / Organisasi' },
      { val: 'fas fa-file-alt', name: 'Administrasi / Word' },
      { val: 'fas fa-gamepad', name: 'Gaming / E-Sport' }
  ];

  function renderSkills() {
    container.innerHTML = '';
    skillsData.forEach((skill, index) => {
      
      // Bikin Dropdown Option-nya
      let optionsHTML = '';
      let isCustom = true;
      iconList.forEach(i => {
          let sel = (i.val === skill.icon) ? 'selected' : '';
          if(sel) isCustom = false;
          optionsHTML += `<option value="${i.val}" ${sel}>${i.name}</option>`;
      });
      // Kalau pakai kode custom
      if(isCustom && skill.icon) {
          optionsHTML += `<option value="${skill.icon}" selected>Custom: ${skill.icon}</option>`;
      }

      const row = document.createElement('div');
      row.className = 'skill-row';
      row.innerHTML = `
        <div class="icon-preview" style="background: ${skill.color}25; color: ${skill.color}; box-shadow: 0 0 15px ${skill.color}40;">
            <i class="${skill.icon}"></i>
        </div>
        <div>
          <label>NAMA SKILL</label>
          <input type="text" value="${skill.name}" onchange="updateData(${index}, 'name', this.value)" placeholder="ex: Laravel" required>
        </div>
        <div style="position: relative;">
          <label>PILIH ICON</label>
          <select onchange="updateData(${index}, 'icon', this.value); renderSkills();">
             ${optionsHTML}
          </select>
          <i class="fas fa-chevron-down" style="position: absolute; right: 15px; top: 40px; pointer-events: none; color: var(--dim);"></i>
        </div>
        <div>
          <label>PILIH WARNA</label>
          <div class="color-wrapper">
             <div class="color-dot" style="background: ${skill.color};"></div>
             <span class="color-hex">${skill.color}</span>
             <input type="color" class="hidden-color-picker" value="${skill.color}" onchange="updateData(${index}, 'color', this.value); renderSkills();">
          </div>
        </div>
        <div style="display:flex; align-items:flex-end;">
          <button type="button" class="btn-remove" onclick="removeSkillRow(${index})" title="Hapus"><i class='bx bx-trash'></i></button>
        </div>
      `;
      container.appendChild(row);
    });
  }

  function updateData(index, key, value) {
    skillsData[index][key] = value;
  }

  function addSkillRow() {
    skillsData.push({ name: '', icon: 'fas fa-code', color: '#4facfe' });
    renderSkills();
  }

  function removeSkillRow(index) {
    skillsData.splice(index, 1);
    renderSkills();
  }

  function prepareData(e) {
    document.getElementById('skills_data').value = JSON.stringify(skillsData);
  }

  renderSkills();
</script>
@endsection