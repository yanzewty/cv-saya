@extends('portfolio.admin_layout')
@section('title', 'Pesan Masuk')

@section('content')
<style>
    /* Header & Navigation */
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 40px; flex-wrap: wrap; gap: 20px; }
    .header-text h1 { font-family: 'Sora', sans-serif; font-size: 32px; font-weight: 800; color: #fff; margin-bottom: 8px; letter-spacing: -0.5px; }
    .header-text p { font-size: 14px; color: var(--text-dim); }
    
    .header-actions { display: flex; gap: 12px; }

    .btn-read-all { display: inline-flex; align-items: center; gap: 8px; background: rgba(52, 199, 123, 0.1); border: 1px solid rgba(52, 199, 123, 0.3); color: #34c77b; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 600; cursor: pointer; transition: 0.3s; }
    .btn-read-all:hover { background: #34c77b; color: #fff; box-shadow: 0 0 15px rgba(52, 199, 123, 0.4); transform: translateY(-4px); }

    .btn-back { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--border-line); color: var(--text-main); padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 600; transition: 0.3s; }
    .btn-back:hover { background: rgba(255,255,255,0.1); transform: translateY(-4px); color: #fff; border-color: var(--cyan); }

    /* Alert Notifikasi Sukses */
    .alert-succ { background: rgba(52, 199, 123, 0.1); border: 1px solid rgba(52, 199, 123, 0.3); color: #34c77b; padding: 16px 20px; border-radius: 12px; font-size: 14px; margin-bottom: 30px; display: flex; align-items: center; gap: 10px; font-weight: 600; }

    /* Grid & Cards */
    .msg-grid { display: grid; gap: 24px; }
    
    .msg-card { 
        background: var(--panel-dark); 
        border: 1px solid var(--border-line); 
        border-radius: 20px;
        padding: 30px; 
        transition: 0.3s; 
        position: relative;
    }
    .msg-card:hover { border-color: var(--cyan); box-shadow: 0 10px 30px rgba(0,0,0,0.2); transform: translateY(-3px); }
    
    /* Titik Merah Notifikasi (Pulse Animation) */
    .notif-dot { position: absolute; top: 20px; right: 20px; width: 12px; height: 12px; background-color: #ff3b30; border-radius: 50%; box-shadow: 0 0 10px rgba(255, 59, 48, 0.6); animation: pulse 2s infinite; transition: 0.3s; }
    @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(255, 59, 48, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(255, 59, 48, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 59, 48, 0); } }
    
    /* Bagian Atas Profil Pengirim */
    .msg-top { 
        display: flex; justify-content: space-between; align-items: flex-start;
        margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.05); 
    }
    
    .msg-info { display: flex; align-items: center; gap: 16px; }
    .msg-avatar { width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--cyan), var(--violet)); display: flex; align-items: center; justify-content: center; font-size: 20px; color: #fff; font-weight: bold; font-family: 'Sora', sans-serif; }
    .msg-name { font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 4px; text-transform: capitalize; }
    .msg-email { font-size: 13px; color: var(--cyan); display: flex; align-items: center; gap: 6px; }
    
    .msg-date-wrap { text-align: right; margin-right: 25px; }
    .msg-date { font-size: 12px; color: var(--text-dim); margin-bottom: 12px; display: flex; align-items: center; gap: 6px; justify-content: flex-end; }
    
    /* Tombol Aksi di dalam Card */
    .msg-actions { display: flex; gap: 8px; justify-content: flex-end; }

    .btn-read { background: rgba(79, 172, 254, 0.1); border: 1px solid rgba(79, 172, 254, 0.3); color: var(--cyan); padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; transition: 0.3s; display: inline-flex; align-items: center; gap: 6px; font-family: 'Inter', sans-serif; }
    .btn-read:hover { background: var(--cyan); color: #000; box-shadow: 0 0 15px rgba(79,172,254,0.4); }

    .btn-delete { background: rgba(255, 59, 48, 0.1); border: 1px solid rgba(255, 59, 48, 0.3); color: var(--danger); padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; transition: 0.3s; display: inline-flex; align-items: center; gap: 6px; font-family: 'Inter', sans-serif; }
    .btn-delete:hover { background: var(--danger); color: #fff; box-shadow: 0 0 15px rgba(255,59,48,0.4); }

    /* Kotak Isi Pesan */
    .msg-body { font-size: 15px; color: var(--text-main); line-height: 1.8; white-space: pre-line; background: rgba(0,0,0,0.2); padding: 24px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.02); }

    /* Saat Kosong */
    .empty-state { text-align: center; padding: 80px 20px; border: 1px dashed var(--border-line); border-radius: 20px; background: rgba(255,255,255,0.01); }
    .empty-state h3 { font-family: 'Sora', sans-serif; font-size: 20px; color: #fff; margin-bottom: 8px; }
    .empty-state p { font-size: 14px; color: var(--text-dim); }
</style>

<div class="page-header">
    <div class="header-text">
        <h1>Pesan Masuk</h1>
        <p>Kelola dan baca pesan yang dikirimkan oleh pengunjung website-mu.</p>
    </div>
    <div class="header-actions">
        <!-- TOMBOL BACA SEMUA: Langsung sikat semua titik merah & tombol biru di halaman -->
        <button type="button" class="btn-read-all" onclick="document.querySelectorAll('.notif-dot, .btn-read').forEach(el => el.style.display = 'none');">
            <i class='bx bx-check-double' style="font-size: 18px;"></i> Tandai Semua Dibaca
        </button>

        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <i class='bx bx-left-arrow-alt' style="font-size: 18px;"></i> Kembali ke Beranda
        </a>
    </div>
</div>

@if (session('success_msg'))
    <div class="alert-succ"><i class='bx bx-check-circle' style="font-size: 20px;"></i> {{ session('success_msg') }}</div>
@endif

<div class="msg-grid">
    @forelse($messages as $msg)
        <div class="msg-card">
            
            <!-- Notifikasi Titik Merah Berkedip -->
            <div class="notif-dot" title="Pesan Baru"></div>
            
            <div class="msg-top">
                <div class="msg-info">
                    <div class="msg-avatar">{{ strtoupper(substr($msg->name, 0, 1)) }}</div>
                    <div>
                        <div class="msg-name">{{ $msg->name }}</div>
                        <div class="msg-email"><i class='bx bx-envelope'></i> {{ $msg->email }}</div>
                    </div>
                </div>
                <div class="msg-date-wrap">
                    <div class="msg-date"><i class='bx bx-time-five'></i> {{ $msg->created_at->format('d M Y, H:i') }}</div>
                    
                    <div class="msg-actions">
                        
                        <!-- TOMBOL BACA 1 PESAN: Perintah javascript langsung nempel di tombolnya -->
                        <button type="button" class="btn-read" onclick="this.closest('.msg-card').querySelector('.notif-dot').style.display='none'; this.style.display='none';">
                            <i class='bx bx-check'></i> Tandai Dibaca
                        </button>
                        
                        <form action="{{ route('admin.messages.delete', $msg->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan dari {{ $msg->name }} ini secara permanen?');" style="margin: 0;">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn-delete"><i class='bx bx-trash'></i> Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="msg-body">"{{ $msg->message }}"</div>
        </div>
    @empty
        <div class="empty-state">
            <i class='bx bx-envelope-open' style="font-size: 60px; color: var(--border-line); margin-bottom: 15px; display: block;"></i>
            <h3>Kotak Masuk Kosong</h3>
            <p>Belum ada pesan baru dari pengunjung website-mu saat ini.</p>
        </div>
    @endforelse
</div>
@endsection