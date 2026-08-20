<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Portfolio - {{ $profile->name ?? 'Alfiansyah' }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
  :root{
    --bg: #0A0E17;
    --panel: #10151F;
    --panel-2: #141B29;
    --line: #232D3E;
    --text: #EAEEF5;
    --dim: #8792A6;
    --violet: #3763E0;
    --pink: #5C7A9E;
    --cyan: #4E9BE0;
    --gold: #C9A24A;
    --font-display: 'Sora', sans-serif;
    --font-body: 'Inter', sans-serif;
    --font-mono: 'JetBrains Mono', monospace;
  }
  *{ margin:0; padding:0; box-sizing:border-box; }
  
  html { scroll-behavior: smooth; scrollbar-width: thin; scrollbar-color: var(--line) var(--bg); }
  body { background: var(--bg); color: var(--text); font-family: var(--font-body); position: relative; overflow-x: hidden; }
  ::selection{ background:var(--pink); color:#0A0A12; }
  a{ color:inherit; text-decoration:none; }
  
  ::-webkit-scrollbar { width: 8px; }
  ::-webkit-scrollbar-track { background: var(--bg); }
  ::-webkit-scrollbar-thumb { background: var(--line); border-radius: 10px; }
  ::-webkit-scrollbar-thumb:hover { background: var(--pink); }

  .preloader{ position:fixed; inset:0; z-index:9999; background:var(--bg); display:flex; align-items:center; justify-content:center; flex-direction:column; gap:18px; transition: transform .9s cubic-bezier(.76,0,.24,1); }
  .preloader.leave{ transform: translateY(-100%); }
  .preloader-logo{ font-family:var(--font-display); font-weight:800; font-size:14px; letter-spacing:2px; color:var(--dim); }
  .preloader-bar{ width:180px; height:2px; background:var(--line); overflow:hidden; border-radius:2px; }
  .preloader-bar span{ display:block; height:100%; width:0%; background:linear-gradient(90deg,var(--violet),var(--pink),var(--cyan)); animation: loadbar 1.2s cubic-bezier(.6,0,.4,1) forwards; }
  @keyframes loadbar{ to{ width:100%; } }

  .mesh{ position:fixed; inset:0; z-index:0; overflow:hidden; pointer-events: none; }
  .mesh .blob{ position:absolute; border-radius:50%; filter:blur(60px); opacity:.22; will-change:transform; }
  .b1{ width:480px; height:480px; background:var(--violet); top:-12%; left:-8%; animation: float1 26s ease-in-out infinite; }
  .b2{ width:420px; height:420px; background:var(--cyan); bottom:-15%; right:-10%; animation: float2 30s ease-in-out infinite; }
  @keyframes float1{ 0%,100%{transform:translate(0,0);} 50%{transform:translate(60px,40px);} }
  @keyframes float2{ 0%,100%{transform:translate(0,0);} 50%{transform:translate(-50px,-40px);} }
  .noise{ position:fixed; inset:0; z-index:1; opacity:.02; pointer-events:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E"); }

  .progress{ position:fixed; top:0; left:0; height:3px; background:linear-gradient(90deg,var(--violet),var(--pink),var(--cyan)); z-index:200; width:0%; }
  main{ position:relative; z-index:2; width: 100%; overflow-x: hidden; }

  nav{ position:sticky; top:0; z-index:100; display:flex; align-items:center; justify-content:space-between; padding:20px 56px; background:rgba(10,14,23,.72); backdrop-filter:blur(8px); border-bottom:1px solid var(--line); width: 100%; }
  .logo{ font-family:var(--font-display); font-weight:700; font-size:18px; letter-spacing:-.5px; }
  .logo span{ background:linear-gradient(90deg,var(--violet),var(--pink)); -webkit-background-clip:text; background-clip:text; color:transparent; }
  .navlinks{ display:flex; gap:26px; font-family:var(--font-mono); font-size:12.5px; color:var(--dim); align-items:center; }
  .navlinks a{ position:relative; }
  .navlinks a::after{ content:""; position:absolute; left:0; bottom:-5px; width:0; height:1px; background:var(--pink); transition:width .3s; }
  .navlinks a:hover::after{ width:100%; }
  .navlinks a:hover{ color:var(--text); }
  
  .nav-admin-group { display: flex; align-items: center; gap: 10px; }
  .nav-admin-btn { font-family: var(--font-mono); font-size: 11.5px; padding: 7px 14px; border-radius: 10px; display: inline-flex; align-items: center; gap: 6px; transition: all .25s ease; cursor: pointer; text-decoration: none; }
  .edit-btn { background: rgba(78,225,214,.1); border: 1px solid rgba(78,225,214,.35); color: var(--cyan); }
  .edit-btn:hover { background: rgba(78,225,214,.2); border-color: var(--cyan); transform: translateY(-1px); color: #fff; }
  .logout-btn { background: rgba(255,93,162,.1); border: 1px solid rgba(255,93,162,.35); color: var(--pink); }
  .logout-btn:hover { background: rgba(255,93,162,.2); border-color: var(--pink); transform: translateY(-1px); color: #fff; }
  .login-btn { background: var(--panel-2); border: 1px solid var(--line); color: var(--dim); }
  .login-btn:hover { border-color: var(--cyan); color: var(--text); }

  .navcta{ font-family:var(--font-mono); font-size:11.5px; padding:10px 22px; border-radius:20px; background:linear-gradient(90deg,var(--violet),var(--pink)); color:#fff; border:none; display:inline-flex; align-items:center; gap:8px; }

  section{ padding:0 56px; position:relative; width: 100%; max-width: 1400px; margin: 0 auto; }
  
  .hero{ min-height:92vh; display:grid; grid-template-columns: 1.1fr 0.9fr; gap:40px; align-items:center; padding-top:40px; width: 100%; }
  .hero-copy { min-width: 0; }
  .eyebrow{ font-family:var(--font-mono); font-size:12px; color:var(--cyan); letter-spacing:2px; text-transform:uppercase; margin-bottom:22px; display:flex; align-items:center; gap:10px; opacity:0; }
  .eyebrow::before{ content:""; width:30px; height:1px; background:var(--cyan); }
  .split-title .row{ overflow:hidden; }
  h1.title{ font-family:var(--font-display); font-weight:800; font-size:clamp(32px, 4.5vw, 68px); line-height:1.05; letter-spacing:-1.5px; word-break: break-word; overflow-wrap: break-word; }
  h1.title .word{ display:inline-block; transform:translateY(0); }
  .grad-text{ background:linear-gradient(90deg,var(--violet),var(--cyan) 55%,var(--violet)); background-size:200% auto; -webkit-background-clip:text; background-clip:text; color:transparent; animation:gradmove 3.5s ease-in-out 3; }
  @keyframes gradmove{ to{ background-position:200% center; } }
  .typing-cursor::after{ content:'_'; animation:blink 1s step-start infinite; color:var(--pink); }
  @keyframes blink{ 50%{ opacity:0; } }
  .lede{ font-family:var(--font-body); font-size:15px; line-height:1.75; color:var(--dim); max-width:540px; margin:22px 0 28px; opacity:0; word-break: break-word; }
  .hero-cta{ display:flex; gap:16px; opacity:0; }
  .btn{ position:relative; font-family:var(--font-mono); font-size:13px; padding:14px 28px; border-radius:8px; cursor:pointer; }
  .btn-primary{ background:linear-gradient(90deg,var(--violet),var(--pink)); color:#fff; border:none; }
  .btn-ghost{ border:1px solid var(--line); color:var(--text); background:transparent; }
  .btn-ghost:hover{ border-color:var(--cyan); }

  .marquee-wrap{ margin-top:40px; border-top:1px solid var(--line); border-bottom:1px solid var(--line); padding:16px 0; overflow:hidden; white-space:nowrap; width: 100%; }
  .marquee{ display:inline-flex; gap:40px; animation:marquee 22s linear infinite; }
  .marquee span{ font-family:var(--font-display); font-size:14px; font-weight:600; color:var(--dim); display:flex; align-items:center; gap:40px; }
  .marquee span em{ font-style:normal; color:var(--pink); }
  @keyframes marquee{ from{ transform:translateX(0); } to{ transform:translateX(-50%); } }

  .hero-img-wrap{ position:relative; width:100%; max-width:340px; margin:0 auto; }
  .hero-img{ position:relative; width:100%; aspect-ratio:3/4; border-radius:22px; overflow:hidden; background:linear-gradient(150deg,#241C3D,#3A1E36 55%,#123B3A); border:1px solid var(--line); }
  .hero-img img{ width:100%; height:100%; object-fit:cover; display:block; }
  .hero-img .glow-ring{ position:absolute; inset:-2px; border-radius:23px; padding:2px; background:linear-gradient(135deg,var(--violet),var(--cyan)); opacity:.55; -webkit-mask:linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0); -webkit-mask-composite:xor; mask-composite:exclude; pointer-events:none; }
  .hero-img .cap{ position:absolute; left:0; right:0; bottom:0; padding:20px 22px; background:linear-gradient(0deg, rgba(10,10,18,.9), transparent); font-family:var(--font-mono); font-size:11.5px; color:var(--dim); z-index:2; }
  .hero-img .cap b{ display:block; font-family:var(--font-display); color:var(--text); font-size:15px; margin-bottom:4px; font-weight:600; }
  .float-badge{ position:absolute; background:var(--panel); border:1px solid var(--line); border-radius:14px; padding:12px 16px; font-family:var(--font-mono); font-size:11px; display:flex; align-items:center; gap:10px; box-shadow:0 20px 40px -20px rgba(0,0,0,.6); z-index:5; white-space: nowrap; }
  .fb1{ top:-16px; right:-16px; animation:bob 5s ease-in-out infinite; }
  .fb2{ bottom:60px; left:-22px; animation:bob 4s ease-in-out infinite 1s; }
  @keyframes bob{ 0%,100%{ transform:translateY(0); } 50%{ transform:translateY(-10px); } }
  .fb-dot{ width:8px; height:8px; border-radius:50%; background:var(--cyan); box-shadow:0 0 10px var(--cyan); }

  .stats{ display:grid; grid-template-columns:repeat(4,1fr); gap:1px; background:var(--line); border:1px solid var(--line); border-radius:16px; overflow:hidden; margin:60px auto; max-width: 1400px; }
  .stat{ background:var(--panel); padding:28px 24px; }
  .stat .tag{ font-family:var(--font-mono); font-size:10.5px; color:var(--cyan); letter-spacing:1px; }
  .stat .val{ font-family:var(--font-display); font-weight:700; font-size:22px; margin-top:10px; }
  .stat .sub{ font-family:var(--font-body); font-size:12px; color:var(--dim); margin-top:5px; }

  .sec-head{ display:flex; justify-content:space-between; align-items:flex-end; margin:120px 0 44px; flex-wrap:wrap; gap:20px; }
  .sec-tag{ font-family:var(--font-mono); font-size:12px; color:var(--gold); letter-spacing:1px; margin-bottom:14px; }
  .sec-title{ font-family:var(--font-display); font-weight:800; font-size:40px; letter-spacing:-1px; }
  .sec-desc{ font-family:var(--font-body); font-size:14px; color:var(--dim); max-width:280px; text-align:right; line-height:1.6; }
  @media (max-width:900px){ .sec-desc{ text-align:left; } }

  .cards{ display:grid; grid-template-columns:repeat(3,1fr); gap:24px; perspective:1200px; }
  .card{ background:linear-gradient(160deg, var(--panel-2), var(--panel)); border:1px solid var(--line); border-radius:18px; padding:0 0 28px; position:relative; overflow:hidden; transform-style:preserve-3d; transition:transform .15s ease, border-color .3s; cursor:pointer; }
  .card::before{ content:""; position:absolute; inset:0; opacity:0; transition:opacity .4s; pointer-events:none; background:radial-gradient(400px circle at var(--mx,50%) var(--my,50%), rgba(139,92,246,.18), transparent 60%); }
  .card:hover::before{ opacity:1; }
  .card:hover{ border-color:var(--violet); }
  .card-img{ height:200px; position:relative; overflow:hidden; clip-path:inset(0 0 100% 0); transition:clip-path 1s cubic-bezier(.16,1,.3,1); }
  .card.in .card-img{ clip-path:inset(0 0 0% 0); }
  .card-img img{ width:100%; height:100%; object-fit:cover; }
  .card-img::after{ content:""; position:absolute; inset:0; background:linear-gradient(0deg, rgba(19,19,31,.95), transparent 55%); }
  .card-body{ padding:22px 26px 0; position:relative; z-index:2; }
  .card .idx{ font-family:var(--font-mono); font-size:11px; color:var(--dim); }
  .card h3{ font-family:var(--font-display); font-weight:700; font-size:19px; margin:12px 0 10px; }
  .card p{ font-family:var(--font-body); font-size:13px; color:var(--dim); line-height:1.6; opacity:0; max-height:0; overflow:hidden; transition:opacity .3s ease, max-height .3s ease; }
  .card:hover p{ opacity:1; max-height:80px; }
  .card .foot{ margin-top:18px; padding-top:14px; border-top:1px solid var(--line); display:flex; justify-content:space-between; font-family:var(--font-mono); font-size:10.5px; color:var(--gold); }

  .about-panel{ background:linear-gradient(160deg, var(--panel-2), var(--panel)); border:1px solid var(--line); border-radius:24px; padding:56px; display:grid; grid-template-columns:1fr 1.3fr; gap:50px; align-items:center; margin:120px auto; max-width: 1400px; }
  .about-panel h2{ font-family:var(--font-display); font-weight:800; font-size:32px; letter-spacing:-1px; line-height:1.25; margin-top:14px; }
  .about-panel p{ color:var(--dim); font-size:16px; line-height:1.8; }
  .hobby-tag{ display:inline-flex; align-items:center; gap:8px; padding:10px 18px; background:var(--bg); border:1px solid var(--line); border-radius:999px; font-size:13px; color:var(--text); margin:6px 6px 0 0; transition:border-color .3s; }
  .hobby-tag:hover{ border-color:var(--cyan); }

  .slider{ position:relative; width:100%; overflow-x:auto; padding:24px 0; margin-top:8px; cursor:grab; user-select:none; scrollbar-width:none; }
  .slider::-webkit-scrollbar{ display:none; }
  .slider:active{ cursor:grabbing; }
  .slider-track{ display:flex; gap:20px; width:max-content; }
  .skill-chip{ background:linear-gradient(160deg, var(--panel-2), var(--panel)); border:1px solid var(--line); border-radius:18px; padding:26px; min-width:250px; min-height:140px; display:flex; flex-direction:column; justify-content:space-between; transition:border-color .3s, transform .3s; flex-shrink:0; }
  .skill-chip:hover{ border-color:var(--violet); transform:translateY(-4px); }
  .skill-chip .ico{ width:38px; height:38px; border-radius:10px; background:linear-gradient(135deg,var(--violet),var(--pink)); display:flex; align-items:center; justify-content:center; margin-bottom:14px; font-size:15px; color:#fff; }
  .skill-chip .lbl{ font-family:var(--font-mono); font-size:10.5px; color:var(--dim); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px; }
  .skill-chip h3{ font-family:var(--font-display); font-size:18px; font-weight:700; }
  .hint{ text-align:center; font-family:var(--font-mono); font-size:11px; color:var(--dim); margin-top:8px; }

  .timeline{ position:relative; padding-left:44px; }
  .timeline .rail{ position:absolute; left:6px; top:6px; bottom:6px; width:2px; background:var(--line); }
  .timeline .rail-fill{ position:absolute; left:0; top:0; width:100%; height:0; background:linear-gradient(180deg,var(--violet),var(--pink)); transition:height 1.2s ease; }
  .t-item{ position:relative; padding-bottom:48px; cursor:pointer; }
  .t-item:last-child{ padding-bottom:0; }
  .t-item::before{ content:""; position:absolute; left:-44px; top:4px; width:15px; height:15px; border-radius:50%; background:var(--bg); border:2px solid var(--violet); z-index:2; }
  .t-item .role{ font-family:var(--font-display); font-weight:700; font-size:18px; transition:color .25s; }
  .t-item:hover .role{ color:var(--pink); }
  .t-item .org{ font-family:var(--font-mono); font-size:12px; color:var(--gold); margin:7px 0 9px; }
  .t-item p{ color:var(--dim); font-size:13.5px; line-height:1.65; max-width:600px; }

  .contact-panel{ max-width:720px; margin:0 auto; background:linear-gradient(160deg, var(--panel-2), var(--panel)); border:1px solid var(--line); border-radius:24px; padding:52px; }
  .field label{ font-family:var(--font-mono); font-size:11px; text-transform:uppercase; letter-spacing:1px; color:var(--dim); display:block; margin-bottom:8px; }
  .field input, .field textarea{ width:100%; padding:14px 16px; background:var(--bg); border:1px solid var(--line); border-radius:12px; color:var(--text); font-family:var(--font-body); font-size:14px; transition:border-color .25s; }
  .field input:focus, .field textarea:focus{ outline:none; border-color:var(--violet); }

  footer{ margin-top:150px; padding:80px 56px 40px; border-top:1px solid var(--line); text-align:center; width: 100%; }
  .footer-title{ font-family:var(--font-display); font-weight:800; font-size:clamp(30px,5vw,56px); letter-spacing:-1.5px; line-height:1.1; }
  .footer-cta{ margin-top:28px; display:inline-flex; padding:16px 34px; border-radius:30px; cursor:pointer; background:linear-gradient(90deg,var(--violet),var(--cyan)); background-size:200% auto; font-family:var(--font-mono); font-size:13px; color:#08101F; font-weight:700; border:none; transition:background-position .6s ease; }
  .footer-cta:hover{ background-position:100% center; }
  .footer-links{ display:flex; justify-content:center; flex-wrap:wrap; gap:24px; margin-top:50px; font-family:var(--font-mono); font-size:12px; color:var(--dim); }
  .footer-links a:hover{ color:var(--cyan); }
  .footer-bottom{ margin-top:44px; font-family:var(--font-mono); font-size:10.5px; color:var(--dim); }

  .reveal{ opacity:0; transform:translateY(28px); transition:opacity .8s cubic-bezier(.16,1,.3,1), transform .8s cubic-bezier(.16,1,.3,1); }
  .reveal.in{ opacity:1; transform:none; }

  .modal-overlay{ position:fixed; inset:0; z-index:500; display:flex; align-items:center; justify-content:center; padding:20px; opacity:0; visibility:hidden; pointer-events:none; transition:opacity .3s ease; }
  .modal-overlay.modal-active{ opacity:1; visibility:visible; pointer-events:auto; }
  .modal-overlay .backdrop{ position:absolute; inset:0; background:rgba(10,10,18,.85); backdrop-filter:blur(6px); }
  .modal-box{ position:relative; z-index:2; width:100%; max-width:640px; background:var(--panel); border:1px solid var(--line); border-radius:22px; overflow:hidden; transform:scale(.95); opacity:0; transition:transform .3s ease, opacity .3s ease; }
  .modal-box.modal-scale{ transform:scale(1); opacity:1; }
  .modal-close{ position:absolute; top:16px; right:16px; width:38px; height:38px; border-radius:50%; background:rgba(0,0,0,.4); display:flex; align-items:center; justify-content:center; color:#fff; z-index:3; border:none; cursor:pointer; transition:background .25s; }
  .modal-close:hover{ background:var(--pink); }
  .modal-img{ width:100%; height:240px; background:var(--panel-2); }
  .modal-img img{ width:100%; height:100%; object-fit:cover; }
  .modal-content{ padding:36px 40px; }
  .modal-cat{ font-family:var(--font-mono); font-size:11px; letter-spacing:1.5px; text-transform:uppercase; color:var(--gold); }
  .modal-title{ font-family:var(--font-display); font-weight:700; font-size:26px; margin:12px 0 16px; }
  .modal-desc{ color:var(--dim); font-size:14px; line-height:1.75; white-space:pre-line; }

  @media (max-width:900px){
    section, nav, footer{ padding-left:20px; padding-right:20px; }
    .navlinks{ display:none; }
    .hero{ grid-template-columns:1fr; min-height:auto; padding-bottom:40px; }
    .hero-img-wrap{ order:-1; margin-bottom:20px; max-width:320px; }
    .stats{ grid-template-columns:repeat(2,1fr); }
    .cards{ grid-template-columns:1fr; }
    .about-panel{ grid-template-columns:1fr; padding:32px; }
  }
</style>
</head>
<body id="home">

<div class="preloader" id="preloader">
  <div class="preloader-logo">{{ strtoupper($profile->name ?? 'PORTFOLIO') }}</div>
  <div class="preloader-bar"><span></span></div>
</div>

<div class="progress"></div>
<div class="mesh"><div class="blob b1"></div><div class="blob b2"></div><div class="blob b3"></div></div>
<div class="noise"></div>

<main>
  <nav>
    <div class="logo">{{ $profile->name ?? 'Portfolio' }}<span>.</span></div>
    <div class="navlinks">
      <a href="#home">Home</a>
      <a href="#About">About</a>
      <a href="#LatarBelakangSkill">Latar Belakang Skill</a>
      <a href="#Keahlian">Keahlian</a>
      <a href="#organization">Organisasi</a>
      
      @auth
        <div class="nav-admin-group">
          <a href="{{ route('admin.dashboard') }}" class="nav-admin-btn edit-btn">
            <i class="fas fa-sliders-h"></i> Edit Portfolio
          </a>
          <form action="{{ route('logout') }}" method="POST" style="display:inline; margin:0;">
            @csrf
            <button type="submit" class="nav-admin-btn logout-btn">
              <i class="fas fa-sign-out-alt"></i> Logout
            </button>
          </form>
        </div>
      @else
        <a href="{{ route('login') }}" class="nav-admin-btn login-btn">
          <i class="fas fa-lock"></i> Admin
        </a>
      @endauth
    </div>
    <a href="#contact" class="navcta">Hubungi Saya</a>
  </nav>

  <section class="hero" id="home">
    <div class="hero-copy">
      <div class="eyebrow" data-anim="fade">Portofolio Siswa &middot; IT Engineering</div>
      <div class="split-title">
        <div class="row"><h1 class="title"><span class="word grad-text typing-cursor" id="typewriter-text"></span></h1></div>
      </div>
      <p class="lede" data-anim="fade">{{ $profile->about ?? '-' }}</p>
      <div class="hero-cta" data-anim="fade">
        <a href="#contact" class="btn btn-primary" data-magnet>Hubungi Saya</a>
      </div>

      <div class="marquee-wrap">
        <div class="marquee">
          @php
            $marqueeSkills = [];
            if(!empty($profile->skills)){
                $ms = is_string($profile->skills) ? json_decode($profile->skills, true) : $profile->skills;
                if(is_array($ms)) $marqueeSkills = $ms;
            }
            if(empty($marqueeSkills)) $marqueeSkills = ['WEB DEVELOPMENT','UI/UX DESIGN','LARAVEL','LEADERSHIP'];
          @endphp
          @for($r = 0; $r < 2; $r++)
          <span>
            @foreach($marqueeSkills as $ms)
                {{ strtoupper($ms) }} <em>&#10022;</em>
            @endforeach
          </span>
          @endfor
        </div>
      </div>
    </div>

    <div class="hero-img-wrap">
      <div class="hero-img">
        <div class="glow-ring"></div>
        @if(!empty($profile->photo))
            <img src="{{ asset('uploads/' . $profile->photo) }}" alt="Foto Profil" onerror="this.src='https://img.freepik.com/free-vector/cute-boy-working-laptop-cartoon-vector-icon-illustration-people-technology-icon-concept-isolated-premium-vector-flat-cartoon-style_138676-3522.jpg'">
        @else
            <img src="https://img.freepik.com/free-vector/cute-boy-working-laptop-cartoon-vector-icon-illustration-people-technology-icon-concept-isolated-premium-vector-flat-cartoon-style_138676-3522.jpg" alt="Foto Profil">
        @endif
        <div class="cap">
          {{ $profile->address ?? 'Alamat' }}
      </div>
      </div>
      
      <!-- Badge 1 (Atas) -->
      @if(!empty($profile->badge_1))
      <div class="float-badge fb1">
          <span class="fb-dot"></span> {{ $profile->badge_1 }}
      </div>
      @endif

      <!-- Badge 2 (Bawah) -->
      @if(!empty($profile->badge_2))
      <div class="float-badge fb2">
          <i class="fas fa-code" style="color:var(--cyan)"></i> {{ $profile->badge_2 }}
      </div>
      @endif
    </div>
  </section>

  <!-- BUNGKUS UTAMA PENYELAMAT -->
  <div style="display: flex; flex-direction: column; gap: 30px; width: 100%; margin: 80px 0;">

    <!-- ====================================================== -->
    <!-- SECTION 1: TENTANG SAYA (DEFAULT)                      -->
    <!-- ====================================================== -->
    <section id="About">
      <div class="about-panel reveal" style="height: auto; min-height: fit-content; padding-bottom: 40px; display: flex; flex-wrap: wrap; gap: 40px; width: 100%; margin: 0 auto;">
        
       <!-- Kiri: Judul Utama -->
        <div style="flex: 1; min-width: 300px;">
          <!-- Teks kecil sekarang memanggil data dinamis dari form -->
          <div class="sec-tag">{{ $profile->about_sub_1 ?? '01 / TENTANG SAYA' }}</div>
          <h2 style="font-family: 'Sora', sans-serif; font-size: 38px; font-weight: 700; color: #fff; line-height: 1.3;">
            {{ $profile->about_title ?? 'Membangun Solusi Digital dengan Logika & Kreativitas' }}
          </h2>
        </div>
     
        <!-- Kanan: 1 Kotak Deskripsi Saja -->
        <div style="flex: 1.2; min-width: 300px; display: flex; flex-direction: column; gap: 20px;">
          @if(!empty($profile->about_1))
            <div style="padding: 30px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; background: rgba(255, 255, 255, 0.03); transition: 0.3s; word-break: break-word; overflow-wrap: break-word;" onmouseover="this.style.borderColor='var(--cyan)'; this.style.background='rgba(255, 255, 255, 0.06)';" onmouseout="this.style.borderColor='rgba(255, 255, 255, 0.1)'; this.style.background='rgba(255, 255, 255, 0.03)';">
              <div style="color: var(--dim); font-size: 15px; line-height: 1.8;">{!! nl2br(e($profile->about_1)) !!}</div>
            </div>
          @endif

          <!-- Tag Hobi (Akan muncul rapi di bawah kotak deskripsi) -->
          @if(!empty($profile->hobbies) && is_array(json_decode($profile->hobbies, true)))
          <div style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 10px;">
            @foreach(json_decode($profile->hobbies, true) as $hobby)
              <span class="hobby-tag"><i class="fas fa-check-circle" style="color:var(--cyan)"></i> {{ $hobby }}</span>
            @endforeach
          </div>
          @endif
        </div>

      </div>
    </section>

    <!-- ====================================================== -->
    <!-- SECTION DINAMIS (TAMBAHAN DARI ADMIN)                  -->
    <!-- ====================================================== -->
    @foreach($panels as $panel)
    <section>
      <div class="about-panel reveal" style="height: auto; min-height: fit-content; padding-bottom: 40px; display: flex; flex-wrap: wrap; gap: 40px; width: 100%; margin: 0 auto;">
        
        <!-- Kiri: Judul Tambahan -->
        <div style="flex: 1; min-width: 300px;">
          <div class="sec-tag">{{ $panel->tag }}</div>
          <h2 style="font-family: 'Sora', sans-serif; font-size: 38px; font-weight: 700; color: #fff; line-height: 1.3;">
            {{ $panel->title }}
          </h2>
        </div>
        
        <!-- Kanan: 1 Kotak Deskripsi Tambahan -->
        <div style="flex: 1.2; min-width: 300px; display: flex; flex-direction: column; gap: 20px;">
          @if(!empty($panel->desc_1))
          <div style="padding: 30px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; background: rgba(255, 255, 255, 0.03); transition: 0.3s; word-break: break-word; overflow-wrap: break-word;" onmouseover="this.style.borderColor='var(--cyan)'; this.style.background='rgba(255, 255, 255, 0.06)';" onmouseout="this.style.borderColor='rgba(255, 255, 255, 0.1)'; this.style.background='rgba(255, 255, 255, 0.03)';">
              <div style="color: var(--dim); font-size: 15px; line-height: 1.8;">{!! nl2br(e($panel->desc_1)) !!}</div>
          </div>
          @endif
        </div>

      </div>
    </section>
    @endforeach
    <!-- AKHIR MAGIC DINAMIS -->

  </div> <!-- PENUTUP BUNGKUS UTAMA PENYELAMAT -->

  <!-- ====================================================== -->
  <!-- BAGIAN 02: LATAR BELAKANG SKILL (KARTU 3D)             -->
  <!-- ====================================================== -->
  <section id="LatarBelakangSkill" style="margin-top: 60px;">
    <div class="sec-head reveal">
      <div><div class="sec-tag">02 / LATAR BELAKANG SKILL</div><div class="sec-title">LATAR BELAKANG SKILL</div></div>
      <div class="sec-desc">Dokumentasi kegiatan pemrograman web, desain UI/UX, dan organisasi sosial.</div>
    </div>
    
    <div class="cards">
      
      @if(isset($dataKeahlian) && $dataKeahlian->count() > 0)
          <!-- ============================================== -->
          <!-- LOOPING DATA DARI DATABASE ADMIN               -->
          <!-- ============================================== -->
          @foreach($dataKeahlian as $item)
          
            @php
                // Logika gambar: kalau ada gambar di database, pakai itu. Kalau kosong, pakai gambar default.
                $gambarUrl = (!empty($item->gambar) && file_exists(public_path('uploads/' . $item->gambar))) 
                             ? asset('uploads/' . $item->gambar) 
                             : 'https://img.freepik.com/free-vector/programming-concept-illustration_114360-1351.jpg'; // Gambar cadangan
                
                // Bersihkan teks dari tanda kutip biar Pop-up Javascript-nya nggak error
                $judulAman = htmlspecialchars($item->judul, ENT_QUOTES);
                $kategoriAman = htmlspecialchars($item->kategori, ENT_QUOTES);
                
                // Hapus enter/baris baru di deskripsi agar script js onclick tidak rusak
                $deskripsiAman = trim(preg_replace('/\s+/', ' ', $item->deskripsi));
                $deskripsiAman = htmlspecialchars($deskripsiAman, ENT_QUOTES);
            @endphp

            <!-- Kartu Dinamis -->
            <div class="card reveal" data-tilt style="transition-delay: .0{{ $loop->index * 8 }}s"
                 onclick="openModal('{{ $judulAman }}', '{{ $kategoriAman }}', '{{ $gambarUrl }}', '{{ $deskripsiAman }}')">
              
              <div class="card-img">
                <img src="{{ $gambarUrl }}" alt="{{ $item->judul }}">
              </div>
              
              <div class="card-body">
                <div class="idx">{{ $item->modul }}</div>
                <h3>{{ $item->judul }}</h3>
                
                <!-- Str::limit untuk memotong teks kepanjangan di dalam kartu (Max 80 huruf) -->
                <p>{{ \Illuminate\Support\Str::limit($item->deskripsi, 80, '...') }}</p>
                
                <div class="foot">
                    <span>{{ $item->kategori }}</span>
                    <span>Klik detail &rarr;</span>
                </div>
              </div>

            </div>
          @endforeach
          
      @else
        
          <p style="color: var(--dim); width: 100%; text-align: center;">Belum ada data skill yang ditambahkan.</p>
      @endif

    </div>
</section>

  <!-- ====================================================== -->
  <!-- BAGIAN 03: KEAHLIAN (SLIDER)                           -->
  <!-- ====================================================== -->
  <section id="Keahlian">
    <div class="sec-head reveal">
      <div><div class="sec-tag">03 / KEAHLIAN</div><div class="sec-title">Bidang Keahlian Saya</div></div>
      <div class="sec-desc">Memadukan kemampuan teknis IT dengan tata kelola organisasi yang rapi.</div>
    </div>

    <div id="skillsSlider" class="slider">
      <div class="slider-track">
        @if(!empty($profile->skills))
          @php
            $skillsList = is_string($profile->skills) ? json_decode($profile->skills, true) : $profile->skills;
            if(is_array($skillsList)){ $originalCount = count($skillsList); $skillsList = array_merge($skillsList, $skillsList); }
          @endphp
          @if(is_array($skillsList))
            @foreach($skillsList as $index => $skill)
            <div class="skill-chip">
              <div>
                <div class="ico"><i class="fas fa-code"></i></div>
                <div class="lbl">Skill_{{ str_pad(($index % $originalCount) + 1, 2, '0', STR_PAD_LEFT) }}</div>
                <h3>{{ $skill }}</h3>
              </div>
            </div>
            @endforeach
          @endif
        @endif
      </div>
    </div>
    <p class="hint"><i class="fas fa-arrows-alt-h"></i> geser dengan mouse atau sentuh layar ke kiri/kanan</p>
  </section>

  <!-- ====================================================== -->
  <!-- BAGIAN 04: PENGALAMAN ORGANISASI (TIMELINE)            -->
  <!-- ====================================================== -->
  <section id="organization">
    <div class="sec-head reveal">
      <div><div class="sec-tag">04 / PENGALAMAN ORGANISASI</div><div class="sec-title">Jejak kepemimpinan</div></div>
      <div class="sec-desc">Peran yang membentuk cara saya bekerja dalam tim dan mengambil keputusan.</div>
    </div>
    <div class="timeline reveal" id="timelineEl">
      <div class="rail"><div class="rail-fill" id="railFill"></div></div>
      @php $experiencesData = json_decode($profile->experiences, true); @endphp
      @if(is_array($experiencesData))
        @foreach($experiencesData as $exp)
        <div class="t-item" onclick="openModal('{{ $exp['posisi'] ?? '' }}', '{{ $exp['periode'] ?? '' }}', '', '{{ $exp['deskripsi'] ?? '' }}\n\nInstansi: {{ $exp['instansi'] ?? '' }}')">
          <div class="role">{{ $exp['posisi'] ?? '' }}</div>
          <div class="org">{{ $exp['instansi'] ?? '' }} &middot; {{ $exp['periode'] ?? '' }}</div>
          <p>{{ Str::limit($exp['deskripsi'] ?? '', 140) }}</p>
        </div>
        @endforeach
      @endif
    </div>
  </section>

  <!-- ====================================================== -->
  <!-- BAGIAN 05: CONTACT FORM                                -->
  <!-- ====================================================== -->
  <section id="contact">
    <div class="sec-head reveal" style="margin-bottom:34px">
      <div><div class="sec-tag">05 / CONTACT</div><div class="sec-title">Kirim Pesan</div></div>
      <div class="sec-desc">Punya pertanyaan, tawaran proyek, atau ingin berdiskusi? Kirim lewat form ini.</div>
    </div>

    <div class="contact-panel reveal">
      <div id="responseMsg" style="display:none;margin-bottom:22px;padding:14px 16px;border-radius:12px;font-size:13px;"></div>

      <form id="contactForm">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
          <div class="field">
            <label>Nama Anda</label>
            <input type="text" name="name" required placeholder="Contoh: Budi ang ang">
          </div>
          <div class="field">
            <label>Email Anda</label>
            <input type="email" name="email" required placeholder="email@gmail.com">
          </div>
        </div>
        <div class="field" style="margin-bottom:24px;">
          <label>Pesan</label>
          <textarea name="message" rows="5" required placeholder="Tuliskan pesan atau kalimat kolaborasi di sini..."></textarea>
        </div>
        <button type="submit" id="submitBtn" class="btn btn-primary" data-magnet style="width:100%;text-align:center;">
          <span id="btnText"><i class="fas fa-paper-plane"></i> Kirim Pesan Sekarang</span>
          <span id="spinner" style="display:none;"><i class="fas fa-spinner fa-spin"></i> Mengirim Pesan...</span>
        </button>
      </form>
    </div>
  </section>

  <footer class="reveal" id="footer">
    <div class="footer-title">Mari wujudkan ide<br>digital <span class="grad-text">berikutnya.</span></div>
    <button class="footer-cta" data-magnet onclick="document.getElementById('contact').scrollIntoView({behavior:'smooth'})">Hubungi Saya &rarr;</button>
    <div class="footer-links">
      <a href="mailto:{{ $profile->email ?? '' }}"><i class="fas fa-envelope"></i> {{ $profile->email ?? '' }}</a>
      <a href="https://wa.me/62{{ substr(str_replace('-', '', $profile->phone ?? ''), 1) }}"><i class="fab fa-whatsapp"></i> {{ $profile->phone ?? '' }}</a>
      @auth
        <a href="{{ route('admin.dashboard') }}" style="color:var(--cyan)">Panel Admin</a>
      @else
        <a href="{{ route('login') }}">Login Admin</a>
      @endauth
    </div>
    <div class="footer-bottom">&copy; {{ date('Y') }} {{ strtoupper($profile->name ?? 'PORTFOLIO') }} &middot; {{ strtoupper($profile->address ?? '') }}</div>
  </footer>
</main>

<!-- MODAL -->
<div id="detailModal" class="modal-overlay">
  <div class="backdrop" onclick="closeModal()"></div>
  <div id="modalContent" class="modal-box">
    <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    <div id="modalImageContainer" class="modal-img" style="display:none;">
      <img id="modalImage" src="" alt="Detail">
    </div>
    <div class="modal-content">
      <div id="modalCategory" class="modal-cat">Kategori</div>
      <div id="modalTitle" class="modal-title">Judul Detail</div>
      <p id="modalDescription" class="modal-desc">Deskripsi detail akan muncul di sini...</p>
    </div>
  </div>
</div>

<script>
  window.addEventListener('DOMContentLoaded', ()=>{
    const pre = document.getElementById('preloader');
    setTimeout(()=>{ pre.classList.add('leave'); setTimeout(()=>pre.remove(), 950); }, 700);
  });

  const textToType = {!! json_encode($profile->role ?? 'Developer') !!};
  const typewriterElement = document.getElementById('typewriter-text');
  let typeIndex = 0;
  function typeWriter(){
    if(typeIndex < textToType.length){
      typewriterElement.textContent += textToType.charAt(typeIndex);
      typeIndex++;
      setTimeout(typeWriter, 85);
    }
  }
  setTimeout(typeWriter, 900);

  document.querySelectorAll('[data-magnet]').forEach(btn=>{
    let rect = null, ticking = false, pendingX = 0, pendingY = 0;
    btn.addEventListener('mouseenter', ()=>{ rect = btn.getBoundingClientRect(); });
    btn.addEventListener('mousemove', e=>{
      if(!rect) rect = btn.getBoundingClientRect();
      pendingX = (e.clientX - rect.left - rect.width/2) * .25;
      pendingY = (e.clientY - rect.top - rect.height/2) * .35;
      if(!ticking){
        ticking = true;
        requestAnimationFrame(()=>{ btn.style.transform = `translate(${pendingX}px, ${pendingY}px)`; ticking = false; });
      }
    });
    btn.addEventListener('mouseleave', ()=>{ btn.style.transform='translate(0,0)'; rect = null; });
  });

  window.addEventListener('DOMContentLoaded', ()=>{
    document.querySelectorAll('[data-anim="fade"]').forEach((el,i)=>{
      setTimeout(()=>{ el.style.transition='opacity .8s ease'; el.style.opacity='1'; }, 400 + i*150);
    });
  });

  const obs = new IntersectionObserver((entries)=>{
    entries.forEach(e=>{
      if(e.isIntersecting){
        e.target.classList.add('in');
        if(e.target.id === 'timelineEl'){ document.getElementById('railFill').style.height = '100%'; }
      } else {
        e.target.classList.remove('in');
        if(e.target.id === 'timelineEl'){ document.getElementById('railFill').style.height = '0%'; }
      }
    });
  }, { threshold:.15 });
  document.querySelectorAll('.reveal, .card').forEach(el=>obs.observe(el));

  const observerOptions = { root: null, rootMargin: '-20% 0px -70% 0px', threshold: 0 };
  const urlObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const id = entry.target.getAttribute('id');
        if (id) {
          if (id === 'home') {
            history.replaceState(null, null, ' ');
          } else {
            history.replaceState(null, null, '#' + id);
          }
        }
      }
    });
  }, observerOptions);
  document.querySelectorAll('section[id], footer[id]').forEach((section) => { urlObserver.observe(section); });

  const progressBar = document.querySelector('.progress');
  const docEl = document.documentElement;
  let scrollable = docEl.scrollHeight - docEl.clientHeight;
  window.addEventListener('resize', ()=>{ scrollable = docEl.scrollHeight - docEl.clientHeight; }, { passive:true });
  let scrollTicking = false;
  window.addEventListener('scroll', ()=>{
    if(scrollTicking) return;
    scrollTicking = true;
    requestAnimationFrame(()=>{
      const pct = scrollable > 0 ? (docEl.scrollTop / scrollable) * 100 : 0;
      progressBar.style.width = pct + '%';
      scrollTicking = false;
    });
  }, { passive:true });

  document.querySelectorAll('[data-tilt]').forEach(card=>{
    let rect = null, ticking = false, px = .5, py = .5;
    card.addEventListener('mouseenter', ()=>{ rect = card.getBoundingClientRect(); });
    card.addEventListener('mousemove', e=>{
      if(!rect) rect = card.getBoundingClientRect();
      px = (e.clientX - rect.left) / rect.width;
      py = (e.clientY - rect.top) / rect.height;
      if(!ticking){
        ticking = true;
        requestAnimationFrame(()=>{
          const rotX = (py-.5) * -8;
          const rotY = (px-.5) * 8;
          card.style.transform = `rotateX(${rotX}deg) rotateY(${rotY}deg) translateY(-4px)`;
          card.style.setProperty('--mx', (px*100)+'%');
          card.style.setProperty('--my', (py*100)+'%');
          ticking = false;
        });
      }
    });
    card.addEventListener('mouseleave', ()=>{ card.style.transform='rotateX(0) rotateY(0)'; rect = null; });
  });

  const slider = document.getElementById('skillsSlider');
  let isDown = false, startX, scrollLeft, isAutoScrolling = true;
  function autoScrollStep(){
    if(isAutoScrolling && !isDown){
      slider.scrollLeft += .6;
      if(slider.scrollLeft >= (slider.scrollWidth / 2)) slider.scrollLeft = 0;
    }
    requestAnimationFrame(autoScrollStep);
  }
  requestAnimationFrame(autoScrollStep);
  slider.addEventListener('mouseenter', ()=>{ isAutoScrolling = false; });
  slider.addEventListener('mouseleave', ()=>{ if(!isDown) isAutoScrolling = true; });
  slider.addEventListener('mousedown', e=>{ isDown = true; isAutoScrolling = false; startX = e.pageX - slider.offsetLeft; scrollLeft = slider.scrollLeft; });
  slider.addEventListener('mouseup', ()=>{ isDown = false; isAutoScrolling = true; });
  slider.addEventListener('mousemove', e=>{
    if(!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    const walk = (x - startX) * 2;
    slider.scrollLeft = scrollLeft - walk;
  });

  document.getElementById('contactForm').onsubmit = async (e) => {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    const spinner = document.getElementById('spinner');
    const btnText = document.getElementById('btnText');
    const msgBox = document.getElementById('responseMsg');

    btn.disabled = true;
    spinner.style.display = 'inline-flex';
    btnText.style.display = 'none';
    msgBox.style.display = 'none';

    try {
      const response = await fetch("{{ route('contact.send') }}", { method: 'POST', body: new FormData(e.target) });
      const result = await response.json();

      if (response.ok) {
        msgBox.style.background = 'rgba(78,225,214,.1)';
        msgBox.style.border = '1px solid rgba(78,225,214,.4)';
        msgBox.style.color = 'var(--cyan)';
        msgBox.innerHTML = `<i class="fas fa-check-circle"></i> ${result.success}`;
        msgBox.style.display = 'block';
        e.target.reset();
        setTimeout(()=>{ msgBox.style.display='none'; window.location.reload(); }, 3000);
      } else {
        throw new Error(result.error || 'Terjadi kesalahan sistem.');
      }
    } catch (err) {
      msgBox.style.background = 'rgba(255,93,162,.1)';
      msgBox.style.border = '1px solid rgba(255,93,162,.4)';
      msgBox.style.color = 'var(--pink)';
      msgBox.innerHTML = `<i class="fas fa-exclamation-triangle"></i> Gagal mengirim pesan. Silakan coba lagi.`;
      msgBox.style.display = 'block';
      btn.disabled = false;
      spinner.style.display = 'none';
      btnText.style.display = 'inline';
    }
  };

  const modal = document.getElementById('detailModal');
  const modalContent = document.getElementById('modalContent');
  const imgContainer = document.getElementById('modalImageContainer');

  function openModal(title, category, imageUrl, description) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalCategory').innerText = category;
    document.getElementById('modalDescription').innerText = description;
    if (imageUrl) {
      document.getElementById('modalImage').src = imageUrl;
      imgContainer.style.display = 'block';
    } else {
      imgContainer.style.display = 'none';
    }
    modal.classList.add('modal-active');
    setTimeout(()=>{ modalContent.classList.add('modal-scale'); }, 10);
    document.body.style.overflow = 'hidden';
  }
  function closeModal() {
    modalContent.classList.remove('modal-scale');
    setTimeout(()=>{ modal.classList.remove('modal-active'); document.body.style.overflow = 'auto'; }, 300);
  }
</script>
</body>
</html>