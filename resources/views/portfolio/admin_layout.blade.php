<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Area - @yield('title')</title>

<!-- Ikon Boxicons -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    :root {
        --bg: #0A0E17; --panel: #10151F; --panel-2: #141B29; --line: #232D3E;
        --text: #EAEEF5; --dim: #8792A6; --primary: #3763E0; --danger: #ff5f56; --success: #27c93f;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
    body { background: var(--bg); color: var(--text); display: flex; min-height: 100vh; overflow-x: hidden; }
    
    .sidebar { width: 260px; background: var(--panel); border-right: 1px solid var(--line); padding: 30px 24px; display: flex; flex-direction: column; position: fixed; height: 100vh; top: 0; left: 0; z-index: 100; }
    .brand { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 30px; display: flex; align-items: center; gap: 12px; }
    .brand i { color: var(--primary); font-size: 28px; }
    
    .nav-menu { display: flex; flex-direction: column; gap: 6px; flex: 1; }
    .nav-label { font-size: 11px; color: var(--dim); padding: 16px 16px 8px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; }
    
    .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--dim); text-decoration: none; border-radius: 12px; font-size: 13.5px; font-weight: 500; transition: all 0.2s; }
    .nav-link i { font-size: 20px; }
    .nav-link:hover, .nav-link.active { background: rgba(55, 99, 224, 0.1); color: var(--primary); }
    .nav-link.logout:hover { background: rgba(255, 95, 86, 0.1); color: var(--danger); }
    
    .main-content { flex: 1; margin-left: 260px; padding: 40px; min-height: 100vh; background: var(--bg); }
    .alert-global { padding: 16px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; display: flex; align-items: center; gap: 10px; }
    .alert-success { background: rgba(39, 201, 63, 0.1); border: 1px solid rgba(39, 201, 63, 0.3); color: var(--success); }
</style>
</head>
<body>

    <aside class="sidebar">
    <div class="brand"><i class='bx bx-cube-alt'></i> Admin CMS</div>
    
    <nav class="nav-menu">
        <span class="nav-label">Menu Website</span>
        
        <a href="{{ route('admin.home') }}" class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}">
            <i class='bx bx-home-alt'></i> Home
        </a>
        
        <a href="{{ route('admin.about') }}" class="nav-link {{ request()->routeIs('admin.about') ? 'active' : '' }}">
            <i class='bx bx-user'></i> About
        </a>

        <!-- Menu Latar Belakang Skill -->
        <a href="{{ route('admin.keahlian') }}" class="nav-link {{ request()->routeIs('admin.keahlian') ? 'active' : '' }}">
            <i class='bx bx-layer'></i> Latar Belakang Skill
        </a>

        <!-- MENU KEAHLIAN (SUDAH DIBENARKAN & BISA NYALA BIRU) -->
        <a href="{{ route('admin.bidang_keahlian') }}" class="nav-link {{ request()->routeIs('admin.bidang_keahlian') ? 'active' : '' }}">
            <i class='bx bx-wrench'></i> Keahlian
        </a>
        
        <a href="{{ route('admin.organizations') }}" class="nav-link {{ request()->routeIs('admin.organizations*') ? 'active' : '' }}">
            <i class='bx bx-group'></i> Organisasi
        </a>
    

        <span class="nav-label">Interaksi</span>
        
        <a href="{{ route('admin.messages') }}" class="nav-link {{ request()->routeIs('admin.messages') ? 'active' : '' }}">
            <i class='bx bx-envelope'></i> Pesan Masuk
        </a>
        
        <!-- Pendorong agar tombol logout selalu ada di bawah -->
        <div style="flex-grow: 1; margin-top: 40px;"></div>

        <!-- Tombol Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link" style="border: none; background: transparent; width: 100%; text-align: left; cursor: pointer;">
                <i class='bx bx-log-out'></i> Logout
            </button>
        </form>
    </nav>
</aside>

    <main class="main-content">
        @if(session('success_msg'))
            <div class="alert-global alert-success"><i class='bx bx-check-circle'></i> {{ session('success_msg') }}</div>
        @endif
        
        @yield('content')
    </main>

</body>
</html>