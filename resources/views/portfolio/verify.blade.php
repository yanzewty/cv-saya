<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verifikasi OTP - Portofolio</title>
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
  .b1{ width:380px; height:380px; background:var(--pink); top:-15%; right:-10%; animation:float1 22s ease-in-out infinite; }
  .b2{ width:320px; height:320px; background:var(--violet); bottom:-15%; left:-10%; animation:float2 26s ease-in-out infinite; }
  @keyframes float1{ 0%,100%{transform:translate(0,0);} 50%{transform:translate(-30px,30px);} }
  @keyframes float2{ 0%,100%{transform:translate(0,0);} 50%{transform:translate(30px,-25px);} }
  .noise{ position:fixed; inset:0; z-index:1; opacity:.02; pointer-events:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E"); }

  .card{ position:relative; z-index:2; width:100%; max-width:420px; background:linear-gradient(160deg, var(--panel-2), var(--panel));
    border:1px solid var(--line); border-radius:22px; overflow:hidden; box-shadow:0 30px 60px -20px rgba(0,0,0,.6);
    opacity:0; transform:translateY(20px); animation:enter .7s cubic-bezier(.16,1,.3,1) forwards; }
  @keyframes enter{ to{ opacity:1; transform:none; } }

  .titlebar{ display:flex; align-items:center; gap:8px; padding:14px 20px; border-bottom:1px solid var(--line); background:rgba(0,0,0,.2); }
  .dot{ width:10px; height:10px; border-radius:50%; }
  .titlebar span:last-child{ margin-left:8px; font-family:var(--font-mono); font-size:11px; color:var(--dim); }

  .body{ padding:36px 34px; }
  .icon-wrap{ width:52px; height:52px; border-radius:16px; background:linear-gradient(135deg,var(--pink),var(--cyan));
    display:flex; align-items:center; justify-content:center; margin:0 auto 18px; font-size:20px; color:#fff; }
  h2{ font-family:var(--font-display); font-weight:700; font-size:24px; text-align:center; }
  .sub{ font-family:var(--font-mono); font-size:11.5px; color:var(--dim); text-align:center; margin-top:8px; line-height:1.5; }

  /* Style untuk Timer */
  .timer-wrap{ text-align:center; margin-top:16px; }
  .timer{ display:inline-flex; align-items:center; gap:8px; padding:8px 16px; background:rgba(78,225,214,.1); border:1px solid rgba(78,225,214,.3); border-radius:12px; font-family:var(--font-mono); font-size:12px; color:var(--cyan); font-weight:600; transition:all .3s ease; }

  /* Kotak Notifikasi */
  .alert{ margin-top:16px; padding:13px 16px; border-radius:12px; font-size:12.5px; display:flex; gap:10px; align-items:flex-start; }
  .alert-success{ background:rgba(78,225,214,.1); border:1px solid rgba(78,225,214,.35); color:var(--cyan); }
  .alert-error{ background:rgba(255,93,162,.1); border:1px solid rgba(255,93,162,.35); color:var(--pink); }

  form{ margin-top:22px; display:flex; flex-direction:column; gap:20px; }
  label{ font-family:var(--font-mono); font-size:11px; text-transform:uppercase; letter-spacing:1px; color:var(--dim); display:block; margin-bottom:8px; text-align:center; }
  .input-wrap{ position:relative; }
  .input-wrap input{ width:100%; padding:15px; background:var(--bg); border:1px solid var(--line); border-radius:12px; color:var(--text); font-size:20px; font-weight:bold; letter-spacing:8px; text-align:center; transition:border-color .25s; }
  .input-wrap input:focus{ outline:none; border-color:var(--pink); }
  .input-wrap input:disabled{ opacity:0.6; cursor:not-allowed; }

  .submit-btn{ margin-top:6px; width:100%; padding:14px; border:none; border-radius:12px; cursor:pointer;
    background:linear-gradient(90deg,var(--pink),var(--cyan)); color:#fff; font-family:var(--font-mono); font-size:13px; font-weight:600;
    display:flex; align-items:center; justify-content:center; gap:8px; transition:all .3s ease; }
  .submit-btn:hover:not(:disabled){ transform:translateY(-2px); }
  .submit-btn:disabled{ background:var(--line); color:var(--dim); cursor:not-allowed; transform:none; }

  /* Style untuk Tombol Minta Kode Ulang */
  .btn-ghost {
    margin-top: 12px; width: 100%; padding: 14px; background: transparent; border: 1px solid var(--line); border-radius: 12px; color: var(--dim); font-family: var(--font-mono); font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: all .3s ease;
  }
  .btn-ghost:hover:not(.disabled) { border-color: var(--cyan); color: var(--text); }
  .btn-ghost.disabled { cursor: not-allowed; opacity: 0.5; pointer-events: none; }

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
    <span>Sistem Keamanan Admin</span>
  </div>

  <div class="body">
    <div class="icon-wrap"><i class="fas fa-shield-alt"></i></div>
    <h2>Verifikasi Kode</h2>
    <p class="sub">Minta kode dari Email Admin</p>

    <!-- Timer Countdown -->
    <div class="timer-wrap">
      <div id="timerDisplay" class="timer">
        <i class="far fa-clock"></i> Memuat waktu...
      </div>
    </div>

    @if(session('success_msg'))
      <div class="alert alert-success"><i class="fas fa-check-circle" style="margin-top:2px"></i><span>{{ session('success_msg') }}</span></div>
    @endif
    @if(session('error_msg'))
      <div class="alert alert-error"><i class="fas fa-exclamation-circle" style="margin-top:2px"></i><span>{{ session('error_msg') }}</span></div>
    @endif

    <form action="{{ route('register.process') }}" method="POST">
      @csrf
      <div>
        <label>MASUKKAN OTP</label>
        <div class="input-wrap">
          <input type="text" id="otpInput" name="otp" required maxlength="6" autocomplete="off" placeholder="------">
        </div>
      </div>

      <button type="submit" id="submitBtn" class="submit-btn"><i class="fas fa-check-circle"></i> Verifikasi & Buat Akun</button>
      
      <!-- Tombol Minta Kode Ulang (Awalnya ter-lock) -->
      <a href="{{ route('register.resend') }}" id="resendBtn" class="btn-ghost disabled">
        <i class="fas fa-redo"></i> Minta Kode Baru (<span id="resendText">...</span>)
      </a>
    </form>
  </div>
</div>

<script>
  // Sinkronisasi Timer dengan Server Laravel (Anti-Refresh)
  @php
    $waktuDibuat = session('reg_otp_time', time());
    $waktuBerjalan = time() - $waktuDibuat;
    $sisaWaktu = max(120 - $waktuBerjalan, 0); // 120 detik = 2 menit
  @endphp

  let timeLeft = {{ $sisaWaktu }};
  const timerDisplay = document.getElementById('timerDisplay');
  const otpInput = document.getElementById('otpInput');
  const submitBtn = document.getElementById('submitBtn');
  const resendBtn = document.getElementById('resendBtn');
  const resendText = document.getElementById('resendText');

  // Jalankan perhitungan langsung 1x supaya tidak nunggu 1 detik
  updateTimerUI(); 

  const countdown = setInterval(() => {
    timeLeft--;
    updateTimerUI();
    
    if (timeLeft <= 0) {
      clearInterval(countdown); // Hentikan timer kalau udah 0
    }
  }, 1000); // Berjalan setiap 1 detik

  function updateTimerUI() {
    if (timeLeft <= 0) {
      // WAKTU HABIS
      timerDisplay.innerHTML = `<i class="fas fa-times-circle"></i> Waktu Habis!`;
      timerDisplay.style.background = 'rgba(255,93,162,.1)';
      timerDisplay.style.borderColor = 'rgba(255,93,162,.3)';
      timerDisplay.style.color = 'var(--pink)';
      
      // Kunci Input dan Tombol Verifikasi
      otpInput.disabled = true;
      submitBtn.disabled = true;
      submitBtn.innerHTML = 'Kode Kadaluarsa';
      
      // BUKA KUNCI Tombol Minta Kode Ulang
      resendBtn.classList.remove('disabled');
      resendBtn.innerHTML = '<i class="fas fa-redo"></i> Minta Kode Baru Sekarang';
      return;
    }

    // Konversi detik ke menit:detik
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;
    
    // Tambahkan angka 0 di depan jika di bawah 10
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;

    const timeString = `${minutes}:${seconds}`;

    // Update tampilan timer
    timerDisplay.innerHTML = `<i class="far fa-clock"></i> Waktu tersisa: ${timeString}`;
    resendText.innerText = timeString;

    // Ubah warna jadi merah pas sisa 30 detik
    if (timeLeft <= 30) {
      timerDisplay.style.background = 'rgba(255,93,162,.1)';
      timerDisplay.style.borderColor = 'rgba(255,93,162,.3)';
      timerDisplay.style.color = 'var(--pink)';
    }
  }
</script>
</body>
</html>