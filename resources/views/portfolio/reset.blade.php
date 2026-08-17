<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buat Password Baru - Portofolio</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  :root{ --bg:#0A0E17; --panel:#10151F; --panel-2:#141B29; --line:#232D3E; --text:#EAEEF5; --dim:#8792A6; --violet:#3763E0; --pink:#5C7A9E; --cyan:#4E9BE0; --font-display:'Sora',sans-serif; --font-body:'Inter',sans-serif; --font-mono:'JetBrains Mono',monospace; }
  *{ margin:0; padding:0; box-sizing:border-box; } body{ background:var(--bg); color:var(--text); font-family:var(--font-body); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px; position:relative; } .mesh{ position:fixed; inset:0; z-index:0; overflow:hidden; } .blob{ position:absolute; border-radius:50%; filter:blur(55px); opacity:.22; } .b1{ width:380px; height:380px; background:var(--pink); top:-15%; right:-10%; } .b2{ width:320px; height:320px; background:var(--violet); bottom:-15%; left:-10%; } .card{ position:relative; z-index:2; width:100%; max-width:420px; background:linear-gradient(160deg, var(--panel-2), var(--panel)); border:1px solid var(--line); border-radius:22px; overflow:hidden; box-shadow:0 30px 60px -20px rgba(0,0,0,.6); } .titlebar{ display:flex; align-items:center; gap:8px; padding:14px 20px; border-bottom:1px solid var(--line); background:rgba(0,0,0,.2); } .dot{ width:10px; height:10px; border-radius:50%; } .titlebar span:last-child{ margin-left:8px; font-family:var(--font-mono); font-size:11px; color:var(--dim); } .body{ padding:36px 34px; } .icon-wrap{ width:52px; height:52px; border-radius:16px; background:linear-gradient(135deg,var(--pink),var(--cyan)); display:flex; align-items:center; justify-content:center; margin:0 auto 18px; font-size:20px; color:#fff; } h2{ font-family:var(--font-display); font-weight:700; font-size:24px; text-align:center; } .sub{ font-family:var(--font-mono); font-size:11.5px; color:var(--dim); text-align:center; margin-top:8px; } .timer-wrap{ text-align:center; margin-top:16px; } .timer{ display:inline-flex; align-items:center; gap:8px; padding:8px 16px; background:rgba(78,225,214,.1); border:1px solid rgba(78,225,214,.3); border-radius:12px; font-family:var(--font-mono); font-size:12px; color:var(--cyan); font-weight:600; } .alert{ margin-top:16px; padding:13px 16px; border-radius:12px; font-size:12.5px; display:flex; gap:10px; } .alert-success{ background:rgba(78,225,214,.1); border:1px solid rgba(78,225,214,.35); color:var(--cyan); } .alert-error{ background:rgba(255,93,162,.1); border:1px solid rgba(255,93,162,.35); color:var(--pink); } form{ margin-top:22px; display:flex; flex-direction:column; gap:20px; } label{ font-family:var(--font-mono); font-size:11px; text-transform:uppercase; letter-spacing:1px; color:var(--dim); display:block; margin-bottom:8px; text-align:center;} .input-wrap{ position:relative; } .input-wrap input{ width:100%; padding:15px; background:var(--bg); border:1px solid var(--line); border-radius:12px; color:var(--text); font-size:16px; font-weight:bold; text-align:center; transition:border-color .25s; } .input-wrap input:focus{ outline:none; border-color:var(--pink); } .submit-btn{ margin-top:6px; width:100%; padding:14px; border:none; border-radius:12px; cursor:pointer; background:linear-gradient(90deg,var(--pink),var(--cyan)); color:#fff; font-family:var(--font-mono); font-size:13px; font-weight:600; display:flex; align-items:center; justify-content:center; gap:8px; } .submit-btn:disabled{ background:var(--line); color:var(--dim); cursor:not-allowed;} .btn-ghost { margin-top:12px; width:100%; padding:14px; background:transparent; border:1px solid var(--line); border-radius:12px; color:var(--dim); font-family:var(--font-mono); font-size:12px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; justify-content:center; align-items:center; gap:8px; } .btn-ghost:hover:not(.disabled) { border-color:var(--cyan); color:var(--text); } .btn-ghost.disabled { cursor:not-allowed; opacity:0.5; pointer-events:none; }
</style>
</head>
<body>
<div class="mesh"><div class="blob b1"></div><div class="blob b2"></div></div>
<div class="card">
  <div class="titlebar"><span class="dot" style="background:#ff5f56"></span><span class="dot" style="background:#ffbd2e"></span><span class="dot" style="background:#27c93f"></span><span>Password Baru</span></div>
  <div class="body">
    <div class="icon-wrap"><i class="fas fa-key"></i></div>
    <h2>Buat Password</h2>
    <p class="sub">// cek emailmu untuk mendapatkan OTP reset</p>

    <div class="timer-wrap"><div id="timerDisplay" class="timer"><i class="far fa-clock"></i> Memuat waktu...</div></div>

    @if(session('success_msg'))<div class="alert alert-success"><i class="fas fa-check-circle" style="margin-top:2px"></i><span>{{ session('success_msg') }}</span></div>@endif
    @if(session('error_msg'))<div class="alert alert-error"><i class="fas fa-exclamation-circle" style="margin-top:2px"></i><span>{{ session('error_msg') }}</span></div>@endif
    @if($errors->any())<div class="alert alert-error"><i class="fas fa-exclamation-circle" style="margin-top:2px"></i><span>{{ $errors->first() }}</span></div>@endif

    <form action="{{ route('password.update') }}" method="POST">
      @csrf
      <div>
        <label>MASUKKAN OTP</label>
        <div class="input-wrap"><input type="text" id="otpInput" name="otp" required maxlength="6" autocomplete="off" placeholder="------" style="letter-spacing:8px;"></div>
      </div>
      <div>
        <label>PASSWORD BARU</label>
        <div class="input-wrap"><input type="password" id="passInput" name="password" required placeholder="Minimal 6 karakter" style="font-size:14px; text-align:left; padding-left:20px;"></div>
      </div>
      <button type="submit" id="submitBtn" class="submit-btn"><i class="fas fa-save"></i> Simpan Password</button>
      <a href="{{ route('password.forget') }}" id="resendBtn" class="btn-ghost disabled"><i class="fas fa-redo"></i> Ulangi Proses (<span id="resendText">...</span>)</a>
    </form>
  </div>
</div>
<script>
  @php
    $waktuDibuat = session('reset_otp_time', time());
    $sisaWaktu = max(120 - (time() - $waktuDibuat), 0); 
  @endphp
  let timeLeft = {{ $sisaWaktu }};
  const timerDisplay = document.getElementById('timerDisplay'), otpInput = document.getElementById('otpInput'), passInput = document.getElementById('passInput'), submitBtn = document.getElementById('submitBtn'), resendBtn = document.getElementById('resendBtn'), resendText = document.getElementById('resendText');

  updateTimerUI(); 
  const countdown = setInterval(() => { timeLeft--; updateTimerUI(); if(timeLeft<=0) clearInterval(countdown); }, 1000);

  function updateTimerUI() {
    if (timeLeft <= 0) {
      timerDisplay.innerHTML = `<i class="fas fa-times-circle"></i> Waktu Habis!`; timerDisplay.style.color = 'var(--pink)';
      otpInput.disabled = true; passInput.disabled = true; submitBtn.disabled = true; submitBtn.innerHTML = 'Kode Kadaluarsa';
      resendBtn.classList.remove('disabled'); resendBtn.innerHTML = '<i class="fas fa-redo"></i> Coba Masukkan Email Lagi';
      return;
    }
    let m = Math.floor(timeLeft / 60), s = timeLeft % 60;
    m = m < 10 ? '0'+m : m; s = s < 10 ? '0'+s : s;
    timerDisplay.innerHTML = `<i class="far fa-clock"></i> Waktu tersisa: ${m}:${s}`; resendText.innerText = `${m}:${s}`;
    if (timeLeft <= 30) timerDisplay.style.color = 'var(--pink)';
  }
</script>
</body>
</html>