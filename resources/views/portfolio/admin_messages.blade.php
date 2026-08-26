@extends('portfolio.admin_layout')
@section('title', 'Pesan Masuk')

@section('content')
@php
    $unreadCount = $messages->where('is_read', false)->count();
    $avatarPalette = [
        ['from' => '#4C6FFF', 'to' => '#29C7C0'],
        ['from' => '#8B5CF6', 'to' => '#4C6FFF'],
        ['from' => '#E8A33D', 'to' => '#F2545B'],
        ['from' => '#29C7C0', 'to' => '#34C77B'],
        ['from' => '#F2545B', 'to' => '#8B5CF6'],
        ['from' => '#34C77B', 'to' => '#29C7C0'],
    ];
@endphp
<style>
    /* ============ HERO HEADER ============ */
    .page-header {
        position: relative; display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 36px; flex-wrap: wrap; gap: 20px; padding: 30px 34px; border-radius: var(--radius-lg);
        border: 1px solid var(--line); overflow: hidden;
        background: linear-gradient(135deg, rgba(139,92,246,0.10), rgba(41,199,192,0.08));
    }
    .page-header::before {
        content: ''; position: absolute; top: -60px; right: -60px; width: 260px; height: 260px;
        background: radial-gradient(circle, rgba(41,199,192,0.22) 0%, transparent 72%); pointer-events: none;
    }
    .header-text { position: relative; z-index: 1; }
    .header-text h1 { font-family: var(--font-display); font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 8px; letter-spacing: -0.5px; display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
    .header-text p { font-size: 13.5px; color: var(--dim); }

    .unread-pill {
        display: inline-flex; align-items: center; gap: 8px; background: rgba(255,59,48,0.12);
        border: 1px solid rgba(255,59,48,0.32); color: #ff8177; padding: 5px 13px; border-radius: 999px;
        font-family: var(--font-mono); font-size: 12px; font-weight: 600; letter-spacing: 0.3px;
    }
    .unread-pill .dot { width: 7px; height: 7px; border-radius: 50%; background: var(--danger); box-shadow: 0 0 8px rgba(255,59,48,0.7); animation: pulse 2s infinite; }
    .unread-pill.zero { background: rgba(52,199,123,0.10); border-color: rgba(52,199,123,0.3); color: var(--success); }
    .unread-pill.zero .dot { background: var(--success); box-shadow: 0 0 8px rgba(52,199,123,0.6); animation: none; }

    .header-actions { position: relative; z-index: 1; display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }

    .btn-read-all, .btn-back, .btn-delete-bulk {
        display: inline-flex; align-items: center; gap: 8px; padding: 11px 18px; border-radius: var(--radius-md);
        font-size: 12.5px; font-weight: 600; cursor: pointer; transition: transform .18s var(--ease), box-shadow .18s var(--ease), background .18s var(--ease);
    }
    .btn-read-all, .btn-back, .btn-delete-bulk { border: 1px solid transparent; }
    .btn-read-all:active, .btn-back:active, .btn-delete-bulk:active, .checkbox-wrapper:active { transform: scale(0.96); }

    .btn-read-all { background: rgba(52,199,123,0.10); border-color: rgba(52,199,123,0.3); color: var(--success); }
    .btn-read-all:hover { background: var(--success); color: #06231f; box-shadow: 0 8px 20px -6px rgba(52,199,123,0.5); transform: translateY(-2px); }

    .btn-back { background: rgba(255,255,255,0.03); border-color: var(--line-strong); color: var(--text); }
    .btn-back:hover { background: rgba(255,255,255,0.08); transform: translateY(-2px); color: #fff; border-color: var(--cyan); }

    .btn-delete-bulk { background: rgba(255,59,48,0.10); border-color: rgba(255,59,48,0.3); color: var(--danger); }
    .btn-delete-bulk:hover { background: var(--danger); color: #fff; box-shadow: 0 8px 20px -6px rgba(255,59,48,0.5); transform: translateY(-2px); }

    .checkbox-wrapper { display: flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.03); padding: 10px 16px; border-radius: var(--radius-md); border: 1px solid var(--line-strong); cursor: pointer; transition: 0.2s var(--ease); margin-bottom: 0; text-transform: none; font-family: 'Inter', sans-serif; letter-spacing: normal; }
    .checkbox-wrapper:hover { border-color: var(--cyan); background: rgba(41,199,192,0.06); }
    .checkbox-wrapper span { font-size: 12.5px; font-weight: 600; color: #fff; text-transform: none; font-family: 'Inter', sans-serif; letter-spacing: normal; }

    /* ============ CUSTOM CHECKBOX ============ */
    input.custom-checkbox { position: absolute; opacity: 0; width: 0; height: 0; }
    .chk-box {
        position: relative; width: 21px; height: 21px; border-radius: 7px; border: 2px solid var(--line-strong);
        background: var(--bg); display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        transition: 0.18s var(--ease); cursor: pointer;
    }
    .chk-box i { font-size: 15px; color: #fff; opacity: 0; transform: scale(0.4) rotate(-20deg); transition: 0.22s cubic-bezier(.34,1.56,.64,1); }
    .chk-box.is-checked { background: var(--primary); border-color: var(--primary); box-shadow: 0 0 0 4px rgba(76,111,255,0.16); }
    .chk-box.is-checked i { opacity: 1; transform: scale(1) rotate(0); }
    .checkbox-wrapper:hover .chk-box { border-color: var(--cyan); }

    /* ============ MESSAGE GRID ============ */
    .msg-grid { display: grid; gap: 16px; }

    .msg-card {
        background: var(--panel); border: 1px solid var(--line); border-radius: var(--radius-lg); padding: 26px;
        transition: transform .2s var(--ease), border-color .2s var(--ease), box-shadow .2s var(--ease), opacity .2s var(--ease);
        position: relative; cursor: pointer; user-select: none; overflow: hidden;
        box-shadow: 0 16px 32px -26px rgba(0,0,0,0.6);
        opacity: 0; animation: cardIn .5s var(--ease) forwards;
    }
    @keyframes cardIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }

    .msg-card::before {
        content: ''; position: absolute; inset: 0 0 0 0; border-radius: inherit; padding: 1px;
        background: linear-gradient(120deg, var(--accent-a, transparent), transparent 40%);
        opacity: 0; transition: opacity .25s var(--ease); pointer-events: none;
        -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        -webkit-mask-composite: xor; mask-composite: exclude;
    }
    .msg-card:hover::before { opacity: 0.5; }
    .msg-card:hover { transform: translateY(-3px); border-color: var(--line-strong); box-shadow: 0 20px 40px -22px rgba(0,0,0,0.55); }

    .msg-card.is-selected { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(76,111,255,0.18), 0 20px 40px -22px rgba(0,0,0,0.55); background: color-mix(in srgb, var(--primary) 5%, var(--panel)); }
    .msg-card.is-read { opacity: 0.55 !important; }
    .msg-card.is-read:hover { opacity: 1 !important; }

    .notif-dot { position: absolute; top: 18px; right: 18px; width: 11px; height: 11px; background-color: var(--danger); border-radius: 50%; box-shadow: 0 0 10px rgba(255,59,48,0.6); animation: pulse 2s infinite; }
    @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(255,59,48,0.6); } 70% { box-shadow: 0 0 0 9px rgba(255,59,48,0); } 100% { box-shadow: 0 0 0 0 rgba(255,59,48,0); } }

    .msg-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 18px; padding-bottom: 18px; border-bottom: 1px solid var(--line); gap: 16px; flex-wrap: wrap; }
    .msg-info { display: flex; align-items: center; gap: 15px; }
    .msg-avatar {
        width: 46px; height: 46px; border-radius: 14px; display: flex; align-items: center; justify-content: center;
        font-size: 17px; color: #fff; font-weight: 700; flex-shrink: 0; font-family: var(--font-display);
        box-shadow: 0 8px 18px -6px rgba(0,0,0,0.5); transition: transform .25s var(--ease);
    }
    .msg-card:hover .msg-avatar { transform: rotate(-4deg) scale(1.05); }
    .msg-name { font-family: var(--font-display); font-size: 16.5px; font-weight: 700; color: #fff; margin-bottom: 3px; text-transform: capitalize; }
    .msg-email { font-size: 12.5px; color: var(--cyan); display: flex; align-items: center; gap: 6px; }

    .msg-date-wrap { text-align: right; }
    .msg-date { font-size: 11.5px; color: var(--dim); margin-bottom: 10px; display: flex; align-items: center; gap: 6px; justify-content: flex-end; cursor: help; }

    .msg-actions { display: flex; gap: 8px; justify-content: flex-end; flex-wrap: wrap; cursor: default; }
    .btn-read, .btn-ban, .btn-delete { padding: 8px 14px; border-radius: 8px; font-size: 11.5px; font-weight: 600; cursor: pointer; transition: transform .18s var(--ease), background .18s var(--ease), box-shadow .18s var(--ease); display: inline-flex; align-items: center; gap: 6px; border: 1px solid transparent; }
    .btn-read:active, .btn-ban:active, .btn-delete:active { transform: scale(0.94); }
    .btn-read { background: rgba(41,199,192,0.10); border-color: rgba(41,199,192,0.3); color: var(--cyan); }
    .btn-read:hover { background: var(--cyan); color: #06231f; box-shadow: 0 6px 16px -6px rgba(41,199,192,0.5); }
    .btn-ban { background: rgba(232,163,61,0.10); border-color: rgba(232,163,61,0.3); color: var(--gold); }
    .btn-ban:hover { background: var(--gold); color: #241a04; box-shadow: 0 6px 16px -6px rgba(232,163,61,0.5); }
    .btn-delete { background: rgba(255,59,48,0.10); border-color: rgba(255,59,48,0.3); color: var(--danger); }
    .btn-delete:hover { background: var(--danger); color: #fff; box-shadow: 0 6px 16px -6px rgba(255,59,48,0.5); }

    .msg-body { font-size: 14px; color: var(--text); line-height: 1.75; white-space: pre-line; background: var(--bg); padding: 20px 22px; border-radius: var(--radius-md); border: 1px solid var(--line); position: relative; }
    .msg-body::before { content: '\201C'; position: absolute; top: -6px; left: 12px; font-family: Georgia, serif; font-size: 40px; color: var(--line-strong); line-height: 1; }

    /* ============ EMPTY STATE ============ */
    .msg-empty { text-align: center; padding: 70px 30px; background: var(--panel); border: 1px dashed var(--line-strong); border-radius: var(--radius-lg); }
    .msg-empty i { font-size: 52px; color: var(--dim); display: block; margin-bottom: 16px; animation: float 3.2s ease-in-out infinite; }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
    .msg-empty h3 { color: var(--text); font-family: var(--font-display); font-size: 16px; margin-bottom: 6px; }
    .msg-empty p { color: var(--dim); font-size: 13px; }
</style>

<div class="page-header">
    <div class="header-text">
        <h1>
            Pesan Masuk
            @if($unreadCount > 0)
                <span class="unread-pill"><span class="dot"></span> {{ $unreadCount }} belum dibaca</span>
            @else
                <span class="unread-pill zero"><span class="dot"></span> Semua terbaca</span>
            @endif
        </h1>
        <p>Kelola dan baca pesan yang dikirimkan oleh pengunjung. Klik kartu pesan untuk centang cepat.</p>
    </div>

    <div class="header-actions">
        <label class="checkbox-wrapper">
            <input type="checkbox" id="selectAll" class="custom-checkbox">
            <span class="chk-box" data-visual-for="selectAll"><i class='bx bx-check'></i></span>
            <span>Pilih Semua</span>
        </label>

        <div id="bulkActionButtons" style="display: none; gap: 12px;">
            <button type="button" class="btn-read-all" onclick="submitBulkAction('read')">
                <i class='bx bx-check-double'></i> Dibaca Terpilih
            </button>
            <button type="button" class="btn-delete-bulk" onclick="submitBulkAction('delete')">
                <i class='bx bx-trash'></i> Hapus Terpilih
            </button>
        </div>

        <form action="{{ route('admin.messages.readAll') }}" method="POST" id="formReadAll" style="margin: 0;">
            @csrf @method('PATCH')
            <button type="submit" class="btn-read-all">
                <i class='bx bx-check-double' style="font-size: 16px;"></i> Tandai Semua Dibaca
            </button>
        </form>

        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <i class='bx bx-left-arrow-alt' style="font-size: 16px;"></i> Kembali
        </a>
    </div>
</div>

@if (session('success_msg'))
    <div class="alert-succ"><i class='bx bx-check-circle' style="font-size: 18px;"></i> <span>{{ session('success_msg') }}</span></div>
@endif

<form id="bulkForm" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="_method" id="bulkMethod">
    <input type="hidden" name="ids" id="bulkIds">
</form>

<div class="msg-grid">
    @forelse($messages as $msg)
        @php $palette = $avatarPalette[crc32($msg->name . $msg->id) % count($avatarPalette)]; @endphp
        <div class="msg-card {{ $msg->is_read ? 'is-read' : '' }}" data-card style="--accent-a: {{ $palette['from'] }}; animation-delay: {{ min($loop->index * 60, 480) }}ms;">
            @if(!$msg->is_read)
                <div class="notif-dot" title="Pesan Baru"></div>
            @endif

            <div class="msg-top">
                <div class="msg-info">
                    <label style="display:flex; align-items:center; cursor:pointer;">
                        <input type="checkbox" class="custom-checkbox msg-checkbox" value="{{ $msg->id }}">
                        <span class="chk-box"><i class='bx bx-check'></i></span>
                    </label>

                    <div class="msg-avatar" style="background: linear-gradient(135deg, {{ $palette['from'] }}, {{ $palette['to'] }});">{{ strtoupper(substr($msg->name, 0, 1)) }}</div>
                    <div>
                        <div class="msg-name">{{ $msg->name }}</div>
                        <div class="msg-email"><i class='bx bx-envelope'></i> {{ $msg->email }}</div>
                    </div>
                </div>
                <div class="msg-date-wrap">
                    <div class="msg-date" title="{{ $msg->created_at->format('d M Y, H:i') }}"><i class='bx bx-time-five'></i> {{ $msg->created_at->diffForHumans() }}</div>

                    <div class="msg-actions">
                        @if(!$msg->is_read)
                            <form action="{{ route('admin.messages.read', $msg->id) }}" method="POST" style="margin: 0;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-read"><i class='bx bx-check'></i> Dibaca</button>
                            </form>
                        @endif

                        @if(!empty($msg->ip_address))
                            <form action="{{ route('admin.messages.ban', $msg->ip_address) }}" method="POST" onsubmit="return confirm('Blokir IP ini selamanya?');" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn-ban"><i class='bx bx-block'></i> Banned IP</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.messages.delete', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');" style="margin: 0;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete"><i class='bx bx-trash'></i> Hapus</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="msg-body">{{ $msg->message }}</div>
        </div>
    @empty
        <div class="msg-empty">
            <i class='bx bx-envelope-open'></i>
            <h3>Kotak Masuk Kosong</h3>
            <p>Belum ada pesan baru dari pengunjung website-mu.</p>
        </div>
    @endforelse
</div>

<script>
    const selectAllCheckbox = document.getElementById('selectAll');
    const msgCheckboxes = document.querySelectorAll('.msg-checkbox');
    const bulkActionButtons = document.getElementById('bulkActionButtons');
    const formReadAll = document.getElementById('formReadAll');

    function visualFor(checkbox) {
        return checkbox.parentElement.querySelector('.chk-box');
    }

    function syncVisual(checkbox) {
        const visual = visualFor(checkbox);
        if (visual) visual.classList.toggle('is-checked', checkbox.checked);
    }

    function updateBulkButtons() {
        const checkedCount = document.querySelectorAll('.msg-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkActionButtons.style.display = 'flex';
            formReadAll.style.display = 'none';
        } else {
            bulkActionButtons.style.display = 'none';
            formReadAll.style.display = 'block';
        }
        selectAllCheckbox.checked = checkedCount === msgCheckboxes.length && msgCheckboxes.length > 0;
        syncVisual(selectAllCheckbox);
    }

    function setCardSelected(checkbox) {
        const card = checkbox.closest('.msg-card');
        if (card) card.classList.toggle('is-selected', checkbox.checked);
        syncVisual(checkbox);
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            msgCheckboxes.forEach(cb => { cb.checked = this.checked; setCardSelected(cb); });
            updateBulkButtons();
        });
    }

    msgCheckboxes.forEach(cb => {
        cb.addEventListener('change', function () { setCardSelected(cb); updateBulkButtons(); });
    });

    document.querySelectorAll('.msg-card').forEach(card => {
        card.addEventListener('click', function (e) {
            if (e.target.closest('.msg-actions')) return;
            const checkbox = card.querySelector('.msg-checkbox');
            if (!checkbox || e.target === checkbox) return;
            checkbox.checked = !checkbox.checked;
            checkbox.dispatchEvent(new Event('change'));
        });
    });

    function submitBulkAction(actionType) {
        let selectedIds = [];
        document.querySelectorAll('.msg-checkbox:checked').forEach(cb => selectedIds.push(cb.value));
        if (selectedIds.length === 0) return;

        let bulkForm = document.getElementById('bulkForm');
        let methodInput = document.getElementById('bulkMethod');
        let idsInput = document.getElementById('bulkIds');
        idsInput.value = selectedIds.join(',');

        if (actionType === 'delete') {
            if (!confirm(`Yakin ingin menghapus ${selectedIds.length} pesan secara permanen?`)) return;
            bulkForm.action = "{{ route('admin.messages.bulkDelete') }}";
            methodInput.value = "DELETE";
        } else if (actionType === 'read') {
            bulkForm.action = "{{ route('admin.messages.bulkRead') }}";
            methodInput.value = "PATCH";
        }

        bulkForm.submit();
    }
</script>
@endsection