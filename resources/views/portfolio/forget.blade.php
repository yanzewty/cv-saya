<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lupa Password - Portofolio</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  :root{ --bg:#0A0E17; --panel:#10151F; --panel-2:#141B29; --line:#232D3E; --text:#EAEEF5; --dim:#8792A6; --violet:#3763E0; --pink:#5C7A9E; --cyan:#4E9BE0; --font-display:'Sora',sans-serif; --font-body:'Inter',sans-serif; --font-mono:'JetBrains Mono',monospace; }
  *{ margin:0; padding:0; box-sizing:border-box; } body{ background:var(--bg); color:var(--text); font-family:var(--font-body); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px; position:relative; } .mesh{ position:fixed; inset:0; z-index:0; overflow:hidden; } .blob{ position:absolute; border-radius:50%; filter:blur(55px); opacity:.22; } .b1{ width:380px; height:380px; background:var(--violet); top:-15%; right:-10%; } .b2{ width:320px; height:320px; background:var(--cyan); bottom:-15%; left:-10%; } .card{ position:relative; z-index:2; width:100%; max-width:420px; background:linear-gradient(160deg, var(--panel-2), var(--panel)); border:1px solid var(--line); border-radius:22px; overflow:hidden; box-shadow:0 30px 60px -20px rgba(0,0,0,.6); } .titlebar{ display:flex; align-items:center; gap:8px; padding:14px 20px; border-bottom:1px solid var(--line); background:rgba(0,0,0,.2); } .dot{ width:10px; height:10px; border-radius:50%; } .titlebar span:last-child{ margin-left:8px; font-family:var(--font-mono); font-size:11px; color:var(--dim); } .body{ padding:36px 34px; } .icon-wrap{ width:52px; height:52px; border-radius:16px; background:linear-gradient(135deg,var(--violet),var(--cyan)); display:flex; align-items:center; justify-content:center; margin:0 auto 18px; font-size:20px; color:#fff; } h2{ font-family:var(--font-display); font-weight:700; font-size:24px; text-align:center; } .sub{ font-family:var(--font-mono); font-size:11.5px; color:var(--dim); text-align:center; margin-top:8px; line-height:1.5;} form{ margin-top:26px; display:flex; flex-direction:column; gap:20px; } label{ font-family:var(--font-mono); font-size:11px; text-transform:uppercase; letter-spacing:1px; color:var(--dim); display:block; margin-bottom:8px; } .input-wrap{ position:relative; } .input-wrap i.left{ position:absolute; left:15px; top:50%; transform:translateY(-50%); color:var(--dim); font-size:13px; } .input-wrap input{ width:100%; padding:13px 14px 13px 42px; background:var(--bg); border:1px solid var(--line); border-radius:12px; color:var(--text); font-size:14px; } .input-wrap input:focus{ outline:none; border-color:var(--cyan); } .submit-btn{ margin-top:6px; width:100%; padding:14px; border:none; border-radius:12px; cursor:pointer; background:linear-gradient(90deg,var(--violet),var(--cyan)); color:#fff; font-family:var(--font-mono); font-size:13px; font-weight:600; display:flex; align-items:center; justify-content:center; gap:8px; } .error{ margin-top:22px; padding:13px 16px; background:rgba(255,93,162,.1); border:1px solid rgba(255,93,162,.35); color:var(--pink); border-radius:12px; font-size:12.5px; display:flex; gap:10px; } .back{ margin-top:26px; padding-top:22px; border-top:1px solid var(--line); text-align:center; } .back a{ font-family:var(--font-mono); font-size:12px; color:var(--dim); text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
</style>
</head>
<body>
<div class="mesh"><div class="blob b1"></div><div class="blob b2"></div></div>
<div class="card">
  <div class="titlebar"><span class="dot" style="background:#ff5f56"></span><span class="dot" style="background:#ffbd2e"></span><span class="dot" style="background:#27c93f"></span><span>Reset Password</span></div>
  <div class="body">
    <div class="icon-wrap"><i class="fas fa-unlock-alt"></i></div>
    <h2>Lupa Password</h2>
    <p class="sub">// masukkan email admin yang terdaftar</p>
    @if($errors->any())<div class="error"><i class="fas fa-exclamation-circle" style="margin-top:2px"></i><span>{{ $errors->first() }}</span></div>@endif
    <form action="{{ route('password.email') }}" method="POST">
      @csrf
      <div>
        <label>Email Admin</label>
        <div class="input-wrap">
          <i class="fas fa-envelope left"></i>
          <input type="email" name="email" required placeholder="email@gmail.com">
        </div>
      </div>
      <button type="submit" class="submit-btn"><i class="fas fa-paper-plane"></i> Kirim Kode OTP</button>
    </form>
    <div class="back"><a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Kembali ke Login</a></div>
  </div>
</div>
</body>
</html>