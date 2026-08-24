<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Portfolio Manager</title>
    
    <!-- Google Fonts: Inter & Sora -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Boxicons & FontAwesome -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #070B14;
            --panel-dark: #10151F;
            --border-line: rgba(255, 255, 255, 0.06);
            --text-main: #EAEEF5;
            --text-dim: #8792A6;
            --cyan: #4facfe;
            --violet: #8B5CF6;
            --danger: #ff3b30;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-dark); color: var(--text-main); display: flex; overflow-x: hidden; }
        a { text-decoration: none; }

        /* ============================
           AREA KONTEN UTAMA (FULL SCREEN)
           ============================ */
        .main-wrapper {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navigation Bar */
        .topbar {
            height: 70px;
            border-bottom: 1px solid var(--border-line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            background: rgba(10, 14, 23, 0.8);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .topbar-breadcrumb { font-size: 13px; color: var(--text-dim); font-weight: 500; display: flex; align-items: center; gap: 14px; }
        .topbar-breadcrumb span { color: #fff; font-weight: 600; }

        /* Tombol Home Baru (Untuk Balik ke Portal) */
        .btn-home { color: var(--cyan); background: rgba(79, 172, 254, 0.1); padding: 8px 14px; border-radius: 10px; display: flex; align-items: center; transition: 0.3s; border: 1px solid rgba(79, 172, 254, 0.3); font-size: 18px; }
        .btn-home:hover { background: var(--cyan); color: #000; box-shadow: 0 0 15px rgba(79,172,254,0.4); transform: translateY(-2px); }

        .topbar-right { display: flex; align-items: center; gap: 24px; }
        .topbar-date { font-size: 12px; font-family: var(--font-mono); color: var(--text-dim); display: flex; align-items: center; gap: 8px; }
        
        /* Tombol Logout Pindah ke Kanan Atas */
        .btn-logout { background: rgba(255,59,48,0.1); border: 1px solid rgba(255,59,48,0.3); color: var(--danger); padding: 9px 18px; border-radius: 10px; cursor: pointer; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; transition: 0.3s; display: flex; align-items: center; gap: 8px; }
        .btn-logout:hover { background: var(--danger); color: #fff; box-shadow: 0 0 15px rgba(255,59,48,0.4); transform: translateY(-2px); }

        /* Wrapper Konten */
        .content-area {
            padding: 40px;
            flex-grow: 1;
            max-width: 1300px;
            margin: 0 auto;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- ==========================================
         AREA KONTEN (TANPA SIDEBAR KIRI)
         ========================================== -->
    <main class="main-wrapper">
        
        <!-- Topbar Keren -->
        <header class="topbar">
            <div class="topbar-breadcrumb">
                <a href="{{ route('admin.dashboard') }}" class="btn-home" title="Kembali ke Dashboard Utama"><i class='bx bx-home-alt-2'></i></a>
                <div><i class='bx bx-folder'></i> Admin / <span>@yield('title')</span></div>
            </div>
            
            <div class="topbar-right">
                <div class="topbar-date">
                    <i class='bx bxs-circle' style="font-size: 8px; color: var(--cyan);"></i> {{ date('l, d M Y') }}
                </div>
                
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class='bx bx-log-out'></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Area Dynamic Form -->
        <section class="content-area">
            @yield('content')
        </section>

    </main>

</body>
</html>