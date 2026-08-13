<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inbox Pesan - Admin</title>
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
  body{ background:var(--bg); color:var(--text); font-family:var(--font-body); min-height:100vh; padding:56px 20px; position:relative; overflow-x:hidden; }
  .mesh{ position:fixed; inset:0; z-index:0; overflow:hidden; }
  .blob{ position:absolute; border-radius:50%; filter:blur(60px); opacity:.2; will-change:transform; }
  .b1{ width:400px; height:400px; background:var(--cyan); top:-15%; right:-10%; animation:float1 26s ease-in-out infinite; }
  .b2{ width:340px; height:340px; background:var(--violet); bottom:-15%; left:-10%; animation:float2 30s ease-in-out infinite; }
  @keyframes float1{ 0%,100%{transform:translate(0,0);} 50%{transform:translate(-30px,30px);} }
  @keyframes float2{ 0%,100%{transform:translate(0,0);} 50%{transform:translate(30px,-25px);} }
  @media (prefers-reduced-motion: reduce){
    *, *::before, *::after{ animation-duration:.01ms !important; animation-iteration-count:1 !important; transition-duration:.01ms !important; }
  }

  .wrap{ position:relative; z-index:2; max-width:820px; margin:0 auto; background:linear-gradient(160deg, var(--panel-2), var(--panel));
    border:1px solid var(--line); border-radius:22px; overflow:hidden; box-shadow:0 30px 60px -20px rgba(0,0,0,.6); }
  .titlebar{ display:flex; align-items:center; gap:8px; padding:14px 22px; border-bottom:1px solid var(--line); background:rgba(0,0,0,.2); }
  .dot{ width:10px; height:10px; border-radius:50%; }
  .titlebar span:last-child{ margin-left:8px; font-family:var(--font-mono); font-size:11px; color:var(--dim); }

  .body{ padding:36px 40px; }
  .head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; padding-bottom:20px; border-bottom:1px solid var(--line); flex-wrap:wrap; gap:14px; }
  .head h1{ font-family:var(--font-display); font-weight:700; font-size:22px; display:flex; align-items:center; gap:10px; }
  .head p{ font-family:var(--font-mono); font-size:11.5px; color:var(--dim); margin-top:6px; }
  .btn-back{ padding:10px 18px; background:var(--bg); border:1px solid var(--line); border-radius:10px; font-size:12px; color:var(--dim); display:inline-flex; align-items:center; gap:8px; transition:border-color .2s, color .2s; }
  .btn-back:hover{ border-color:var(--cyan); color:var(--text); }

  .alert-ok{ margin-bottom:22px; padding:14px 16px; border-radius:12px; font-size:13px; background:rgba(78,225,214,.1); border:1px solid rgba(78,225,214,.35); color:var(--cyan); display:flex; gap:10px; align-items:center; }

  .msg{ background:var(--bg); border:1px solid var(--line); border-radius:16px; padding:22px; margin-bottom:16px; transition:transform .25s ease, border-color .25s ease; }
  .msg:hover{ transform:translateX(4px); border-color:var(--violet); }
  .msg-top{ display:flex; justify-content:space-between; align-items:flex-start; gap:12px; flex-wrap:wrap; }
  .msg-top h3{ font-family:var(--font-display); font-size:15.5px; font-weight:700; }
  .msg-top a{ font-family:var(--font-mono); font-size:11.5px; color:var(--cyan); text-decoration:none; }
  .msg-time{ font-family:var(--font-mono); font-size:10.5px; color:var(--dim); }
  .msg-body{ margin-top:14px; font-size:13.5px; color:var(--dim); line-height:1.65; background:var(--panel); border:1px solid var(--line); border-radius:10px; padding:14px 16px; }
  .msg-actions{ display:flex; justify-content:flex-end; margin-top:14px; }
  .del-btn{ background:none; border:none; color:var(--pink); font-size:12px; display:flex; align-items:center; gap:6px; cursor:pointer; font-family:var(--font-body); }
  .del-btn:hover{ text-decoration:underline; }

  .empty{ text-align:center; padding:60px 20px; color:var(--dim); }
  .empty i{ font-size:32px; margin-bottom:14px; display:block; }
  .empty span{ font-family:var(--font-mono); font-size:12px; }
</style>
</head>
<body>
<div class="mesh"><div class="blob b1"></div><div class="blob b2"></div></div>

<div class="wrap">
  <div class="titlebar">
    <span class="dot" style="background:#ff5f56"></span>
    <span class="dot" style="background:#ffbd2e"></span>
    <span class="dot" style="background:#27c93f"></span>
    <span>Pesan</span>
  </div>

  <div class="body">
    <div class="head">
      <div>
        <h1><i class="fas fa-inbox" style="color:var(--pink)"></i> Daftar Pesan Masuk</h1>
        <p>pesan dari pengunjung melalui form kontak web portofolio</p>
      </div>
      <a href="{{ route('portofolio.edit') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Edit Web</a>
    </div>

    @if(session('success'))
      <div class="alert-ok"><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>
    @endif

    @forelse($messages as $msg)
      <div class="msg">
        <div class="msg-top">
          <div>
            <h3>{{ $msg->name }}</h3>
            <a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a>
          </div>
          <span class="msg-time">{{ $msg->created_at->diffForHumans() }}</span>
        </div>
        <div class="msg-body">{{ $msg->message }}</div>
        <div class="msg-actions">
          <form action="{{ route('admin.messages.delete', $msg->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="del-btn"><i class="fas fa-trash"></i> Hapus Pesan</button>
          </form>
        </div>
      </div>
    @empty
      <div class="empty">
        <i class="fas fa-folder-open"></i>
        <span>// belum ada pesan masuk</span>
      </div>
    @endforelse
  </div>
</div>
</body>
</html>