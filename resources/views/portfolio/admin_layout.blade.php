<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Portfolio Manager</title>

    <!-- Google Fonts: Sora (display), Inter (body), JetBrains Mono (labels/data) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Boxicons & FontAwesome -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        /* ============================================================
           DESIGN TOKENS — satu sumber kebenaran untuk semua halaman admin
           ============================================================ */
        :root {
            --bg: #0A0E16;
            --panel: #10151F;
            --panel-2: #161C28;
            --line: rgba(255, 255, 255, 0.07);
            --line-strong: rgba(255, 255, 255, 0.16);

            --text: #EAEEF5;
            --dim: #8792A6;

            --primary: #4C6FFF;
            --primary-dark: #3B57D9;
            --cyan: #29C7C0;
            --violet: #8B5CF6;
            --gold: #E8A33D;
            --pink: #F2545B;
            --danger: #FF3B30;
            --success: #34C77B;

            --font-display: 'Sora', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;

            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 18px;

            --ease: cubic-bezier(.4,0,.2,1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg); color: var(--text); display: flex; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        button { font-family: inherit; }

        ::selection { background: var(--primary); color: #fff; }

        /* Scrollbar, halus & senyap */
        ::-webkit-scrollbar { width: 10px; height: 10px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--line-strong); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--dim); }

        /* ============================================================
           SHELL
           ============================================================ */
        .main-wrapper { width: 100%; min-height: 100vh; display: flex; flex-direction: column; }

        .topbar {
            height: 68px;
            border-bottom: 1px solid var(--line);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 40px;
            background: rgba(10, 14, 22, 0.82);
            backdrop-filter: blur(10px);
            position: sticky; top: 0; z-index: 90;
        }

        .topbar-breadcrumb { font-size: 13px; color: var(--dim); font-weight: 500; display: flex; align-items: center; gap: 14px; }
        .topbar-breadcrumb span { color: #fff; font-weight: 600; }

        .btn-home { color: var(--cyan); background: rgba(41,199,192,0.10); padding: 8px 14px; border-radius: var(--radius-sm); display: flex; align-items: center; transition: 0.25s var(--ease); border: 1px solid rgba(41,199,192,0.3); font-size: 18px; }
        .btn-home:hover { background: var(--cyan); color: #06231f; box-shadow: 0 0 18px rgba(41,199,192,0.35); transform: translateY(-2px); }

        .topbar-right { display: flex; align-items: center; gap: 22px; }
        .topbar-date { font-size: 12px; font-family: var(--font-mono); color: var(--dim); display: flex; align-items: center; gap: 8px; }

        .btn-logout { background: rgba(255,59,48,0.08); border: 1px solid rgba(255,59,48,0.3); color: var(--danger); padding: 9px 18px; border-radius: var(--radius-sm); cursor: pointer; font-size: 12px; font-weight: 600; transition: 0.25s var(--ease); display: flex; align-items: center; gap: 8px; }
        .btn-logout:hover { background: var(--danger); color: #fff; box-shadow: 0 0 18px rgba(255,59,48,0.35); transform: translateY(-2px); }

        .content-area { padding: 40px; flex-grow: 1; max-width: 1300px; margin: 0 auto; width: 100%; animation: fadeInUp .45s var(--ease) both; }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        @media (prefers-reduced-motion: reduce) {
            * { animation-duration: 0.001ms !important; transition-duration: 0.001ms !important; }
        }

        /* ============================================================
           SHARED COMPONENTS — dipakai bersama di semua halaman kelola konten
           ============================================================ */
        .wrap-form { max-width: 900px; margin: 0 auto; }

        .header-flex { display: flex; justify-content: space-between; align-items: flex-end; gap: 20px; margin-bottom: 32px; flex-wrap: wrap; }
        .header-flex h1 { font-family: var(--font-display); font-size: 26px; font-weight: 700; margin-bottom: 6px; color: #fff; }
        .header-flex p { color: var(--dim); font-size: 13.5px; }

        .btn-outline { padding: 10px 18px; border: 1px solid var(--line-strong); border-radius: var(--radius-sm); font-size: 13px; color: var(--text); display: inline-flex; align-items: center; gap: 8px; transition: 0.2s var(--ease); background: rgba(255,255,255,0.02); font-weight: 500; }
        .btn-outline:hover { border-color: var(--cyan); color: #fff; background: rgba(41,199,192,0.10); transform: translateY(-1px); }

        .alert-succ {
            background: rgba(52,199,123,0.10); border: 1px solid rgba(52,199,123,0.3); color: var(--success);
            padding: 14px 18px; border-radius: var(--radius-md); font-size: 13.5px; display: flex; align-items: center;
            gap: 10px; margin-bottom: 24px; font-weight: 500; animation: fadeInUp .35s var(--ease) both;
            overflow: hidden; max-height: 200px;
            transition: opacity .4s var(--ease), transform .4s var(--ease), max-height .4s var(--ease), margin .4s var(--ease), padding .4s var(--ease), border-width .4s var(--ease);
        }
        .alert-succ.alert-hide { opacity: 0; transform: translateY(-8px); max-height: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; border-width: 0; }
        .alert-close { margin-left: auto; background: none; border: none; color: inherit; cursor: pointer; font-size: 19px; opacity: 0.55; transition: opacity .2s var(--ease); display: flex; padding: 2px; flex-shrink: 0; }
        .alert-close:hover { opacity: 1; }

        .card-form {
            --accent: var(--primary);
            background: var(--panel); border: 1px solid var(--line); border-radius: var(--radius-lg);
            padding: 30px; margin-bottom: 26px; position: relative; overflow: hidden;
            box-shadow: 0 20px 40px -28px rgba(0,0,0,0.6);
            transition: border-color .2s var(--ease);
        }
        .card-form::before { content: ''; position: absolute; top: 0; left: 0; width: 3px; height: 100%; background: var(--accent); }
        .card-form:hover { border-color: var(--line-strong); }
        .card-form.dashed { border-style: dashed; border-color: color-mix(in srgb, var(--accent) 45%, transparent); background: color-mix(in srgb, var(--accent) 4%, var(--panel)); }
        .card-form.dashed::before { display: none; }

        .form-title { font-size: 14.5px; color: #fff; margin-bottom: 22px; display: flex; align-items: center; gap: 9px; font-weight: 700; font-family: var(--font-display); }
        .form-title i { color: var(--accent); font-size: 19px; }

        .form-group { margin-bottom: 20px; }
        label { font-family: var(--font-mono); font-size: 10.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: var(--dim); display: block; margin-bottom: 9px; }

        input[type=text], input[type=email], textarea, select {
            width: 100%; padding: 13px 15px; background: var(--bg); border: 1px solid var(--line);
            border-radius: var(--radius-sm); color: var(--text); font-size: 13.5px; font-family: 'Inter', sans-serif;
            transition: border-color .2s var(--ease), box-shadow .2s var(--ease); appearance: none;
        }
        input[type=text]:focus, input[type=email]:focus, textarea:focus, select:focus {
            outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent) 18%, transparent);
        }
        select option { background: var(--panel-2); color: #fff; }
        textarea { resize: vertical; }

        .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .grid3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
        @media (max-width: 640px) { .grid2, .grid3 { grid-template-columns: 1fr; } }

        .submit-btn {
            width: 100%; padding: 15px; border: none; border-radius: var(--radius-md); cursor: pointer;
            background: var(--primary); color: #fff; font-size: 13.5px; font-weight: 700;
            display: flex; justify-content: center; align-items: center; gap: 8px;
            transition: transform .2s var(--ease), box-shadow .2s var(--ease), background .2s var(--ease);
        }
        .submit-btn:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 14px 28px -10px rgba(76,111,255,0.4); }
        .submit-btn.accent-cyan { background: var(--cyan); color: #06231f; }
        .submit-btn.accent-cyan:hover { background: #35d8d0; box-shadow: 0 14px 28px -10px rgba(41,199,192,0.4); }

        .btn-add {
            background: color-mix(in srgb, var(--cyan) 10%, transparent); color: var(--cyan);
            border: 1px dashed var(--cyan); width: 100%; padding: 15px; border-radius: var(--radius-md);
            cursor: pointer; font-weight: 600; font-size: 13.5px; transition: 0.2s var(--ease);
            display: flex; justify-content: center; align-items: center; gap: 8px;
        }
        .btn-add:hover { background: var(--cyan); color: #06231f; transform: translateY(-1px); }

        .btn-edit, .btn-delete {
            padding: 10px 16px; border-radius: 9px; cursor: pointer; display: inline-flex; align-items: center;
            gap: 6px; font-weight: 600; font-size: 12.5px; transition: 0.2s var(--ease); border: 1px solid transparent;
        }
        .btn-edit { background: rgba(76,111,255,0.10); color: var(--primary); border-color: rgba(76,111,255,0.3); }
        .btn-edit:hover { background: var(--primary); color: #fff; }
        .btn-delete { background: rgba(242,84,91,0.10); color: var(--pink); border-color: rgba(242,84,91,0.3); }
        .btn-delete:hover { background: var(--danger); color: #fff; }

        .btn-remove {
            background: rgba(242,84,91,0.10); color: var(--pink); border: 1px solid rgba(242,84,91,0.3);
            width: 40px; height: 40px; border-radius: var(--radius-sm); cursor: pointer; transition: 0.2s var(--ease);
            display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0;
        }
        .btn-remove:hover { background: var(--danger); color: #fff; transform: scale(1.06); }

        .list-item {
            background: var(--panel); border: 1px solid var(--line); border-radius: 14px; padding: 18px 22px;
            margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; gap: 16px;
            flex-wrap: wrap; transition: 0.2s var(--ease);
        }
        .list-item:hover { border-color: var(--line-strong); transform: translateX(3px); }

        .empty-state {
            text-align: center; padding: 36px; background: rgba(255,255,255,0.02);
            border: 1px dashed var(--line-strong); border-radius: 14px; color: var(--dim);
        }
        .empty-state i { font-size: 32px; margin-bottom: 8px; display: block; }
        .empty-state p { font-size: 13px; font-style: italic; }

        .section-divider { border: none; border-top: 1px dashed var(--line); margin: 42px 0; }
        .section-heading { font-family: var(--font-display); font-size: 19px; color: #fff; font-weight: 700; margin-bottom: 6px; }
        .section-subheading { color: var(--dim); font-size: 13px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <main class="main-wrapper">

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

        <section class="content-area">
            @yield('content')
        </section>

    </main>

    <script>
        // Auto-dismiss notifikasi sukses supaya tidak "nempel" terus di layar
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.alert-succ').forEach(function (alertEl) {
                var closeBtn = document.createElement('button');
                closeBtn.type = 'button';
                closeBtn.className = 'alert-close';
                closeBtn.setAttribute('aria-label', 'Tutup notifikasi');
                closeBtn.innerHTML = "<i class='bx bx-x'></i>";
                closeBtn.addEventListener('click', function () { dismissAlert(alertEl); });
                alertEl.appendChild(closeBtn);

                setTimeout(function () { dismissAlert(alertEl); }, 4500);
            });

            function dismissAlert(el) {
                if (!el || el.classList.contains('alert-hide')) return;
                el.classList.add('alert-hide');
                setTimeout(function () { el.remove(); }, 450);
            }
        });
    </script>

</body>
</html>