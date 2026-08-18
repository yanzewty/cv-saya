<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login - Portofolio</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  :root{
    --bg:#0A0E17; --panel:#10151F; --panel-2:#141B29; --line:#232D3E; --text:#EAEEF5; --dim:#8792A6;
    --violet:#3763E0; --pink:#5C7A9E; --cyan:#4E9BE0;
    --font-display:'Sora',sans-serif; --font-body:'Inter',sans-serif; --font-mono:'JetBrains Mono',monospace;
  }
  *{ margin:0; padding:0; box-sizing:border-box; }
  body{ background:var(--bg); color:var(--text); font-family:var(--font-body); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px; overflow:hidden; position:relative; }
  .mesh{ position:fixed; inset:0; z-index:0; overflow:hidden; }
  .blob{ position:absolute; border-radius:50%; filter:blur(55px); opacity:.22; will-change:transform; }
  .b1{ width:380px; height:380px; background:var(--violet); top:-15%; right:-10%; animation:float1 22s ease-in-out infinite; }
  .b2{ width:320px; height:320px; background:var(--cyan); bottom:-15%; left:-10%; animation:float2 26s ease-in-out infinite; }
  @keyframes float1{ 0%,100%{transform:translate(0,0);} 50%{transform:translate(-30px,30px);} }
  @keyframes float2{ 0%,100%{transform:translate(0,0);} 50%{transform:translate(30px,-25px);} }
  .noise{ position:fixed; inset:0; z-index:1; opacity:.02; pointer-events:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E"); }
  @media (prefers-reduced-motion: reduce){
    *, *::before, *::after{ animation-duration:.01ms !important; animation-iteration-count:1 !important; transition-duration:.01ms !important; }
  }

  .card{ position:relative; z-index:2; width:100%; max-width:420px; background:linear-gradient(160deg, var(--panel-2), var(--panel));
    border:1px solid var(--line); border-radius:22px; overflow:hidden; box-shadow:0 30px 60px -20px rgba(0,0,0,.6);
    opacity:0; transform:translateY(20px); animation:enter .7s cubic-bezier(.16,1,.3,1) forwards; }
  @keyframes enter{ to{ opacity:1; transform:none; } }

  .titlebar{ display:flex; align-items:center; gap:8px; padding:14px 20px; border-bottom:1px solid var(--line); background:rgba(0,0,0,.2); }
  .dot{ width:10px; height:10px; border-radius:50%; }
  .titlebar span:last-child{ margin-left:8px; font-family:var(--font-mono); font-size:11px; color:var(--dim); }

  .body{ padding:36px 34px; }
  .icon-wrap{ width:52px; height:52px; border-radius:16px; background:linear-gradient(135deg,var(--violet),var(--pink));
    display:flex; align-items:center; justify-content:center; margin:0 auto 18px; font-size:20px; color:#fff; }
  h2{ font-family:var(--font-display); font-weight:700; font-size:24px; text-align:center; }
  .sub{ font-family:var(--font-mono); font-size:11.5px; color:var(--dim); text-align:center; margin-top:8px; }

  .error{ margin-top:22px; padding:13px 16px; background:rgba(255,93,162,.1); border:1px solid rgba(255,93,162,.35); color:var(--pink); border-radius:12px; font-size:12.5px; display:flex; gap:10px; align-items:flex-start; }
  
 
  .success{ margin-top:22px; padding:13px 16px; background:rgba(78,225,214,.1); border:1px solid rgba(78,225,214,.35); color:var(--cyan); border-radius:12px; font-size:12.5px; display:flex; gap:10px; align-items:flex-start; }

  form{ margin-top:26px; display:flex; flex-direction:column; gap:20px; }
  label{ font-family:var(--font-mono); font-size:11px; text-transform:uppercase; letter-spacing:1px; color:var(--dim); display:block; margin-bottom:8px; }
  .input-wrap{ position:relative; }
  .input-wrap i.left{ position:absolute; left:15px; top:50%; transform:translateY(-50%); color:var(--dim); font-size:13px; }
  .input-wrap input{ width:100%; padding:13px 14px 13px 42px; background:var(--bg); border:1px solid var(--line); border-radius:12px; color:var(--text); font-size:14px; transition:border-color .25s; }
  .input-wrap input:focus{ outline:none; border-color:var(--violet); }
  .eye-btn{ position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; color:var(--dim); cursor:pointer; font-size:13px; }
  .eye-btn:hover{ color:var(--text); }

  .submit-btn{ margin-top:6px; width:100%; padding:14px; border:none; border-radius:12px; cursor:pointer;
    background:linear-gradient(90deg,var(--violet),var(--pink)); color:#fff; font-family:var(--font-mono); font-size:13px; font-weight:600;
    display:flex; align-items:center; justify-content:center; gap:8px; transition:transform .2s; }
  .submit-btn:hover{ transform:translateY(-2px); }

  .back{ margin-top:26px; padding-top:22px; border-top:1px solid var(--line); text-align:center; }
  .back a{ font-family:var(--font-mono); font-size:12px; color:var(--dim); text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:color .2s; }
  .back a:hover{ color:var(--cyan); }
</style>
</head>
<body>
<div class="mesh"><div class="blob b1"></div><div class="blob b2"></div></div>
<div class="noise"></div>

<div class="card">
  <div class="titlebar">
    <span class="dot" style="background:#ff5f56"></span>
    <span class="dot" style="background:#ffbd2e"></span>
    <span class="dot" style="background:#27c93f"></span>
    <span>Login Admin</span>
  </div>

  <div class="body">
    <div class="icon-wrap"><i class="fas fa-lock"></i></div>
    <h2>Admin Login</h2>
    <p class="sub">silakan masuk untuk mengelola portofolio</p>

    
    @if($errors->any())
      <div class="error"><i class="fas fa-exclamation-circle" style="margin-top:2px"></i><span>{{ $errors->first() }}</span></div>
    @endif

    @if(session('success_msg'))
      <div class="success"><i class="fas fa-check-circle" style="margin-top:2px"></i><span>{{ session('success_msg') }}</span></div>
    @endif

    <form action="{{ route('login') }}" method="POST">
      @csrf
      <div>
        <label>Email</label>
        <div class="input-wrap">
          <i class="fas fa-envelope left"></i>
          <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@gmail.com">
        </div>
      </div>

      <div>
        <label>Password</label>
        <div class="input-wrap">
          <i class="fas fa-key left"></i>
          <input type="password" name="password" id="passwordField" required placeholder="••••••••" style="padding-right:42px;">
          <button type="button" class="eye-btn" onclick="togglePasswordVisibility()"><i id="eyeIcon" class="fas fa-eye"></i></button>
        </div>
        
        
        <div style="text-align: right; margin-top: 8px;">
          <a href="{{ route('password.forget') }}" style="color: var(--dim); font-size: 11px; font-family: var(--font-mono); text-decoration: none; transition: color .2s;" onmouseover="this.style.color='var(--cyan)'" onmouseout="this.style.color='var(--dim)'">Lupa Password?</a>
        </div>
      </div>

      <button type="submit" class="submit-btn"><i class="fas fa-sign-in-alt"></i> Masuk Admin</button>
    </form>
      {{-- ini untuk buka regist tapi keknya ga aku pakek deh  --}}
    {{-- <div class="back" style="display: flex; flex-direction: column; gap: 12px;">
      <a href="{{ route('register') }}" style="color: var(--cyan);"><i class="fas fa-user-plus"></i> Belum punya akun? Minta akses di sini</a>
      <a href="{{ route('portofolio.index') }}"><i class="fas fa-arrow-left"></i> Kembali ke Beranda Portofolio</a>
    </div> --}}
  </div>
</div>

<script>
  function togglePasswordVisibility() {
    const passwordInput = document.getElementById('passwordField');
    const eyeIcon = document.getElementById('eyeIcon');
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      eyeIcon.classList.remove('fa-eye'); eyeIcon.classList.add('fa-eye-slash');
    } else {
      passwordInput.type = 'password';
      eyeIcon.classList.remove('fa-eye-slash'); eyeIcon.classList.add('fa-eye');
    }
  }
</script>
</body>
</html>