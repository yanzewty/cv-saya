@extends('portfolio.admin_layout')
@section('title', 'Kelola Bidang Keahlian')

@section('content')
<style>
  .skill-row {
      display: grid; grid-template-columns: 56px 1.4fr 1.4fr 120px 44px; gap: 14px; align-items: end;
      background: var(--panel); padding: 16px; border-radius: var(--radius-md); border: 1px solid var(--line);
      margin-bottom: 14px; transition: 0.25s var(--ease);
  }
  .skill-row:hover { border-color: var(--gold); }
  @media (max-width: 800px) { .skill-row { grid-template-columns: 1fr; } }

  .icon-preview { width: 46px; height: 46px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 22px; transition: 0.25s var(--ease); }

  .color-wrapper { position: relative; width: 100%; height: 48px; background: var(--bg); border: 1px solid var(--line); border-radius: var(--radius-sm); display: flex; align-items: center; padding: 0 12px; transition: 0.2s var(--ease); }
  .color-wrapper:hover { border-color: var(--gold); }
  .color-dot { width: 20px; height: 20px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.2); flex-shrink: 0; }
  .color-hex { margin-left: 10px; font-family: var(--font-mono); font-size: 12.5px; color: #fff; text-transform: uppercase; font-weight: 500; }
  .hidden-color-picker { position: absolute; inset: 0; opacity: 0; width: 100%; height: 100%; cursor: pointer; }

  .select-wrap { position: relative; }
  .select-wrap i { position: absolute; right: 14px; bottom: 15px; pointer-events: none; color: var(--dim); font-size: 12px; }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="wrap-form" style="max-width: 950px;">
  <div class="header-flex">
    <div>
      <h1>Bidang Keahlian</h1>
      <p>Tinggal pilih Icon, ketik Nama, sesuaikan Warna, lalu Simpan.</p>
    </div>
    <a href="{{ route('portofolio.index') }}#Keahlian" target="_blank" class="btn-outline">
      <i class='bx bx-link-external'></i> Lihat Website
    </a>
  </div>

  @if (session('success_msg'))
    <div class="alert-succ"><i class='bx bx-check-circle'></i> <span>{{ session('success_msg') }}</span></div>
  @endif

  <form action="{{ route('admin.bidang_keahlian.update') }}" method="POST" id="mainForm" onsubmit="prepareData(event)">
    @csrf
    <input type="hidden" name="skills_data" id="skills_data">

    <div class="card-form">
      <div class="form-title"><i class='bx bx-text'></i> Teks Judul (Header)</div>
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

    <div class="card-form" style="--accent: var(--gold);">
      <div class="form-title"><i class='bx bx-category'></i> Daftar Keahlian</div>

      <div id="skills-container"></div>

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

      let optionsHTML = '';
      let isCustom = true;
      iconList.forEach(i => {
          let sel = (i.val === skill.icon) ? 'selected' : '';
          if (sel) isCustom = false;
          optionsHTML += `<option value="${i.val}" ${sel}>${i.name}</option>`;
      });
      if (isCustom && skill.icon) {
          optionsHTML += `<option value="${skill.icon}" selected>Custom: ${skill.icon}</option>`;
      }

      const row = document.createElement('div');
      row.className = 'skill-row';
      row.innerHTML = `
        <div class="icon-preview" style="background: ${skill.color}25; color: ${skill.color}; box-shadow: 0 0 14px ${skill.color}35;">
            <i class="${skill.icon}"></i>
        </div>
        <div>
          <label>Nama Skill</label>
          <input type="text" value="${skill.name}" onchange="updateData(${index}, 'name', this.value)" placeholder="ex: Laravel" required>
        </div>
        <div class="select-wrap">
          <label>Pilih Icon</label>
          <select onchange="updateData(${index}, 'icon', this.value); renderSkills();">
             ${optionsHTML}
          </select>
          <i class="fas fa-chevron-down"></i>
        </div>
        <div>
          <label>Pilih Warna</label>
          <div class="color-wrapper">
             <div class="color-dot" style="background: ${skill.color};"></div>
             <span class="color-hex">${skill.color}</span>
             <input type="color" class="hidden-color-picker" value="${skill.color}" onchange="updateData(${index}, 'color', this.value); renderSkills();">
          </div>
        </div>
        <button type="button" class="btn-remove" onclick="removeSkillRow(${index})" title="Hapus"><i class='bx bx-trash'></i></button>
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