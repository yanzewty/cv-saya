@extends('portfolio.admin_layout')
@section('title', 'Beranda Dashboard')

@section('content')
<style>
 
  .dash-welcome { 
      background: linear-gradient(135deg, rgba(139,92,246,0.15), rgba(79,172,254,0.15)); 
      border: 1px solid rgba(79,172,254,0.3); 
      border-radius: 24px; 
      padding: 40px 45px; 
      display: flex; 
      align-items: center; 
      justify-content: space-between;
      margin-bottom: 40px; 
      position: relative; 
      overflow: hidden; 
  }
  .dash-welcome::before { 
      content: ''; position: absolute; right: -50px; top: -50px; 
      width: 300px; height: 300px; 
      background: radial-gradient(circle, rgba(79,172,254,0.2) 0%, transparent 70%); 
      border-radius: 50%; pointer-events: none; 
  }
  .welcome-text h1 { font-family: 'Sora', sans-serif; font-size: 32px; color: #fff; margin-bottom: 12px; font-weight: 800; letter-spacing: -0.5px; }
  .welcome-text p { color: var(--text-dim); font-size: 15px; line-height: 1.7; max-width: 600px; }
  
  .btn-primary { 
      background: linear-gradient(90deg, var(--violet), var(--cyan)); 
      color: #fff; padding: 14px 28px; border-radius: 12px; 
      display: inline-flex; align-items: center; gap: 8px; 
      font-weight: 600; font-size: 14px; margin-top: 24px; transition: 0.3s; 
      text-decoration: none;
  }
  .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3); filter: brightness(1.1); }


  .section-title { font-family: 'Sora', sans-serif; font-size: 18px; color: #fff; margin-bottom: 20px; font-weight: 700; display: flex; align-items: center; gap: 8px; }
  .section-title i { color: var(--cyan); }

  .grid-quick-links { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; }
  .ql-card { 
      display: flex; align-items: center; background: var(--panel-dark); 
      border: 1px solid var(--border-line); border-radius: 20px; padding: 24px; 
      text-decoration: none; transition: 0.3s; position: relative; 
  }
  .ql-card:hover { border-color: var(--cyan); transform: translateY(-5px); box-shadow: 0 10px 25px rgba(79, 172, 254, 0.15); background: rgba(255,255,255,0.02); }
  
  .ql-icon { width: 55px; height: 55px; border-radius: 14px; background: rgba(255,255,255,0.03); display: flex; align-items: center; justify-content: center; font-size: 26px; color: var(--text-main); margin-right: 18px; transition: 0.3s; border: 1px solid var(--border-line); }
  .ql-card:hover .ql-icon { background: linear-gradient(135deg, var(--violet), var(--cyan)); color: #fff; border-color: transparent; }
  
  .ql-text h4 { color: #fff; font-size: 16px; font-weight: 600; margin-bottom: 4px; font-family: 'Sora', sans-serif; display: flex; align-items: center; gap: 8px; }
  .ql-text p { color: var(--text-dim); font-size: 13px; line-height: 1.5; }
  
  .ql-arrow { margin-left: auto; color: var(--text-dim); font-size: 24px; transition: 0.3s; }
  .ql-card:hover .ql-arrow { color: var(--cyan); transform: translateX(5px); }

  
  .badge-total {
      background-color: rgba(255,255,255,0.1);
      color: var(--text-main);
      font-size: 10px;
      padding: 3px 8px;
      border-radius: 12px;
      font-weight: 600;
  }
</style>

<div class="dash-welcome">
  <div class="welcome-text">
    <h1>Halo, Admin </h1>
    <p>Selamat datang di pusat kendali. Pantau pesan pengunjung dan kelola konten website-mu melalui menu navigasi di bawah ini.</p>
    <a href="{{ route('portofolio.index') }}" target="_blank" class="btn-primary">
        <i class='bx bx-rocket'></i> Lihat Website Sekarang
    </a>
  </div>
</div>

<h2 class="section-title"><i class='bx bx-grid-alt'></i> Menu Navigasi Portal</h2>
<div class="grid-quick-links">
    
    <a href="{{ route('admin.home') }}" class="ql-card">
        <div class="ql-icon"><i class='bx bx-home-smile'></i></div>
        <div class="ql-text">
            <h4>Edit Home & Profil</h4>
            <p>Ubah foto, nama, dan bio utama.</p>
        </div>
        <div class="ql-arrow"><i class='bx bx-right-arrow-alt'></i></div>
    </a>

    <a href="{{ route('admin.about') }}" class="ql-card">
        <div class="ql-icon"><i class='bx bx-user'></i></div>
        <div class="ql-text">
            <h4>Tentang Saya (About)</h4>
            <p>Kelola paragraf deskripsi dan hobi.</p>
        </div>
        <div class="ql-arrow"><i class='bx bx-right-arrow-alt'></i></div>
    </a>

    <a href="{{ route('admin.latar_belakang') }}" class="ql-card">
        <div class="ql-icon"><i class='bx bx-layer'></i></div>
        <div class="ql-text">
            <h4>Latar Belakang Skill</h4>
            <p>Edit daftar skill utama.</p>
        </div>
        <div class="ql-arrow"><i class='bx bx-right-arrow-alt'></i></div>
    </a>

    <a href="{{ route('admin.keahlian') }}" class="ql-card">
        <div class="ql-icon"><i class='bx bx-wrench'></i></div>
        <div class="ql-text">
            <h4>Bidang Keahlian</h4>
            <p>Edit Banner berjalan.</p>
        </div>
        <div class="ql-arrow"><i class='bx bx-right-arrow-alt'></i></div>
    </a>

    <a href="{{ route('admin.organizations') }}" class="ql-card">
        <div class="ql-icon"><i class='bx bx-group'></i></div>
        <div class="ql-text">
            <h4>Jejak Organisasi</h4>
            <p>Tambah log pengalaman & riwayat.</p>
        </div>
        <div class="ql-arrow"><i class='bx bx-right-arrow-alt'></i></div>
    </a>

    {{-- pesan masuk --}}
    <a href="{{ route('admin.messages') }}" class="ql-card" style="border-color: rgba(255, 171, 0, 0.2);">
        <div class="ql-icon" style="color: #ffab00;">
            <i class='bx bx-envelope'></i>
        </div>
        
        <div class="ql-text">
            <h4>
                Pesan Masuk 
                
                <span class="badge-total">{{ $totalMessages }} Pesan</span>
            </h4>
            <p>Baca pesan dari pengunjung website.</p>
        </div>
        <div class="ql-arrow"><i class='bx bx-right-arrow-alt'></i></div>
    </a>

</div>
<br><br>
@endsection