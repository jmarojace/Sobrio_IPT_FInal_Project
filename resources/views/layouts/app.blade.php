<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} · {{ config('app.name', 'Pasture') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#20372d; --muted:#7d8980; --green:#24583f; --green-deep:#173d2b; --cream:#f6f5ef; --line:#e9ebe3; --terra:#c8794d; }
        body { background:var(--cream); color:var(--ink); font-family:'DM Sans',sans-serif; }
        h1,h2,h3,h4,h5,.brand { font-family:'Manrope',sans-serif; }
        .app-shell { min-height:100vh; }
        .sidebar { width:260px; flex:0 0 260px; background:linear-gradient(165deg,#173d2b 0%,#20533a 65%,#286145 100%); color:#f8f7ef; }
        .brand-mark { display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:14px; background:#e4edda; color:var(--green-deep); box-shadow:0 4px 12px #102f2340; }
        .brand-mark svg { width:23px; height:23px; }
        .brand { color:#fff; letter-spacing:-.04em; font-size:18px; }
        .brand-caption { color:#bfd0c3; }
        .sidebar .eyebrow { color:#9fbaa6; }
        .side-link { display:flex; align-items:center; gap:12px; padding:11px 13px; color:#d0ddd2; text-decoration:none; border-radius:11px; font-weight:600; font-size:14px; transition:background .18s ease,color .18s ease,transform .18s ease; }
        .side-link svg { width:18px; height:18px; opacity:.88; }
        .side-link:hover { background:#ffffff14; color:#fff; transform:translateX(2px); }
        .side-link.active { background:#f4f0df; color:#214c37; box-shadow:0 5px 14px #102f2330; }
        .side-link.active svg { color:var(--terra); opacity:1; }
        .sidebar-note { background:#ffffff12; border:1px solid #ffffff18; color:#e7eee7; }
        .sidebar-note-mark { display:inline-flex; width:7px; height:7px; border-radius:50%; background:#e7b17b; box-shadow:0 0 0 4px #e7b17b26; }
        .main-content { min-width:0; }
        .topbar { height:72px; background:#fbfaf6ed; border-bottom:1px solid var(--line); backdrop-filter:blur(12px); }
        .page-wrap { max-width:1360px; }
        .eyebrow { color:#66806d; font-size:11px; font-weight:700; letter-spacing:.13em; text-transform:uppercase; }
        .text-muted-custom { color:var(--muted); }
        .card { border:1px solid var(--line); border-radius:18px; background:#fffefa; box-shadow:0 8px 26px #23392b08; }
        .stat-card { position:relative; overflow:hidden; transition:transform .2s ease,box-shadow .2s ease; }
        .stat-card:hover { transform:translateY(-3px); box-shadow:0 14px 32px #23392b12; }
        .stat-card::after { content:''; position:absolute; right:-22px; bottom:-35px; width:90px; height:90px; border-radius:50%; background:var(--stat-tint,#e9f0e5); opacity:.65; }
        .stat-icon { display:flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:14px; background:var(--stat-tint,#e9f0e5); color:var(--stat-color,#24583f); }
        .stat-icon svg { width:20px; height:20px; }
        .btn { font-weight:600; transition:transform .15s ease,box-shadow .15s ease; }
        .btn:hover { transform:translateY(-1px); }
        .btn-success { --bs-btn-bg:#24583f; --bs-btn-border-color:#24583f; --bs-btn-hover-bg:#173d2b; --bs-btn-hover-border-color:#173d2b; --bs-btn-active-bg:#173d2b; }
        .btn-outline-success { --bs-btn-color:#24583f; --bs-btn-border-color:#cad7ca; --bs-btn-hover-bg:#24583f; --bs-btn-hover-border-color:#24583f; }
        .table thead th { color:#819087; font-size:10px; text-transform:uppercase; letter-spacing:.11em; font-weight:700; border-bottom-width:1px; white-space:nowrap; background:#fafaf6; }
        .table td { vertical-align:middle; color:#34483d; }
        .table-hover>tbody>tr:hover>* { --bs-table-bg:#f7f8f2; }
        .form-control,.form-select { border-color:#dfe5dc; border-radius:11px; padding:.7rem .85rem; background-color:#fffefa; }
        .form-control:focus,.form-select:focus { border-color:#83a78c; box-shadow:0 0 0 .22rem #24583f1a; background-color:#fff; }
        .form-label { color:#3a4e41; font-size:13px; }
        .record-count { display:inline-flex; align-items:center; gap:7px; padding:7px 11px; border:1px solid #e4e8dd; border-radius:999px; background:#fffefa; color:#65746a; font-size:12px; font-weight:600; }
        .record-count strong { color:#24583f; }
        .form-card-heading { display:flex; align-items:center; gap:12px; padding-bottom:20px; margin-bottom:26px; border-bottom:1px solid var(--line); }
        .form-card-icon { display:flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:14px; background:#e9f0e5; color:#24583f; }
        .form-card-icon svg { width:20px; height:20px; }
        .detail-label { color:#819087; font-size:11px; letter-spacing:.07em; text-transform:uppercase; }
        .detail-value { color:#2d4436; font-weight:600; }
        .alert-success { background:#eaf2e8; color:#28563e; }
        .alert-danger { background:#f8eae5; color:#854b3d; }
        .nav-toggle { display:none; }
        .footer-text { color:#8b968d; }
        .icon-sprite { position:absolute; width:0; height:0; overflow:hidden; }
        @media(max-width:767px) { .sidebar { width:100%; flex-basis:auto; border-right:0; border-bottom:1px solid #ffffff20; } .sidebar-nav { display:grid!important; grid-template-columns:repeat(2,minmax(0,1fr)); } .side-link { padding:9px 10px; font-size:13px; } .sidebar-note { display:none; } .topbar { height:58px; } }
        @media(prefers-reduced-motion:reduce) { *,*::before,*::after { scroll-behavior:auto!important; transition:none!important; } }
    </style>
    @stack('styles')
</head>
<body>
<svg class="icon-sprite" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
    <symbol id="icon-leaf" viewBox="0 0 24 24"><path d="M20 4c-8 0-13 3.8-13 10a6 6 0 0 0 6 6c6.2 0 10-5 10-13V4h-3Z"/><path d="M4 21c3-5 7-8 12-11"/></symbol>
    <symbol id="icon-home" viewBox="0 0 24 24"><path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/></symbol>
    <symbol id="icon-animal" viewBox="0 0 24 24"><path d="M7 8 5 5M17 8l2-3M6 12c0-3 2.7-5 6-5s6 2 6 5v5a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3v-5Z"/><path d="M9 12h.01M15 12h.01M10 16c1.2 1 2.8 1 4 0"/></symbol>
    <symbol id="icon-breed" viewBox="0 0 24 24"><path d="M12 3v18M5 7c4 0 7 2 7 5M19 7c-4 0-7 2-7 5M5 17c4 0 7-2 7-5M19 17c-4 0-7-2-7-5"/></symbol>
    <symbol id="icon-farm" viewBox="0 0 24 24"><path d="m3 11 9-7 9 7v9H3v-9Z"/><path d="M8 20v-6h8v6M9 9h.01M15 9h.01"/></symbol>
    <symbol id="icon-health" viewBox="0 0 24 24"><path d="M12 21s-8-4.5-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 10c0 6.5-8 11-8 11Z"/><path d="M9 12h6M12 9v6"/></symbol>
    <symbol id="icon-feed" viewBox="0 0 24 24"><path d="M12 21V9M12 14c-4 0-7-2-7-6 4 0 7 2 7 6ZM12 11c0-4 2-7 6-8 1 4-1 7-6 8Z"/><path d="M5 21h14"/></symbol>
    <symbol id="icon-sun" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4m11.4 11.4 1.4 1.4M2 12h2m16 0h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></symbol>
</svg>
<div class="app-shell d-md-flex">
    <aside class="sidebar p-3 p-md-4">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-3 text-decoration-none mb-4">
            <span class="brand-mark"><svg><use href="#icon-leaf"></use></svg></span>
            <span><span class="brand fw-bold d-block">Pasture</span><small class="brand-caption">Livestock manager</small></span>
        </a>
        <div class="eyebrow px-2 mb-2">Workspace</div>
        <nav class="sidebar-nav d-flex flex-column gap-1">
            <a class="side-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><svg><use href="#icon-home"></use></svg> Overview</a>
            <a class="side-link {{ request()->routeIs('animals.*') ? 'active' : '' }}" href="{{ route('animals.index') }}"><svg><use href="#icon-animal"></use></svg> Animals</a>
            <a class="side-link {{ request()->routeIs('breeds.*') ? 'active' : '' }}" href="{{ route('breeds.index') }}"><svg><use href="#icon-breed"></use></svg> Breeds</a>
            <a class="side-link {{ request()->routeIs('farms.*') ? 'active' : '' }}" href="{{ route('farms.index') }}"><svg><use href="#icon-farm"></use></svg> Farms</a>
            <a class="side-link {{ request()->routeIs('vaccinations.*') ? 'active' : '' }}" href="{{ route('vaccinations.index') }}"><svg><use href="#icon-health"></use></svg> Vaccinations</a>
            <a class="side-link {{ request()->routeIs('feeding-records.*') ? 'active' : '' }}" href="{{ route('feeding-records.index') }}"><svg><use href="#icon-feed"></use></svg> Feeding records</a>
        </nav>
        <div class="sidebar-note mt-5 p-3 rounded-4">
            <div class="d-flex align-items-center gap-2 fw-bold small mb-2"><span class="sidebar-note-mark"></span> A little farm note</div>
            <div class="small" style="color:#cad8cc">Good records make it easier to care for every animal.</div>
        </div>
    </aside>
    <div class="main-content flex-grow-1">
        <header class="topbar d-flex align-items-center justify-content-between px-4 px-lg-5">
            <div class="small text-muted-custom">Livestock Management System <span class="d-none d-sm-inline">· Philippines</span></div>
            <div class="d-flex align-items-center gap-2 small fw-semibold"><span class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width:30px;height:30px;background:#e7eddf;color:#24583f">P</span><span class="d-none d-sm-inline">Farm workspace</span></div>
        </header>
        <main class="page-wrap container-fluid px-4 px-lg-5 py-4 py-lg-5">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 rounded-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3" role="alert">
                    <div class="fw-bold mb-1">Please review the highlighted fields.</div>
                    <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </main>
        <footer class="footer-text px-4 px-lg-5 pb-4 small">Pasture · Livestock Management System</footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
