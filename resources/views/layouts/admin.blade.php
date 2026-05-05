<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title', 'Dashboard') — H2WHOA Admin</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,600,700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style nonce="{{ csp_nonce() }}">
        :root {
            --sidebar-bg: #1a1a2e;
            --sidebar-width: 224px;
            --brand: #4ac9b0;
            --brand-dark: #35b39a;
            --topbar-h: 60px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f9;
            margin: 0;
            overflow-x: hidden;
        }

        /* ── Sidebar ── */
        #sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 200;
            transition: width .2s;
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 1.1rem 1.25rem;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }
        .sidebar-brand span {
            font-family: 'Nunito', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: .04em;
        }
        .sidebar-nav {
            list-style: none;
            padding: .75rem 0;
            margin: 0;
            flex: 1;
            overflow-y: auto;
        }
        .sidebar-nav li a {
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: .65rem 1.25rem;
            color: rgba(255,255,255,.6);
            text-decoration: none;
            font-size: .82rem;
            font-weight: 600;
            letter-spacing: .03em;
            transition: color .15s, background .15s;
            border-radius: 6px;
            margin: 1px .5rem;
        }
        .sidebar-nav li a i {
            width: 18px;
            text-align: center;
            font-size: .85rem;
            flex-shrink: 0;
        }
        .sidebar-nav li a:hover {
            color: #fff;
            background: rgba(255,255,255,.07);
        }
        .sidebar-nav li a.active {
            color: var(--brand);
            background: rgba(74,201,176,.12);
        }
        .sidebar-nav li a.active i { color: var(--brand); }

        /* ── Topbar ── */
        #topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            z-index: 100;
        }
        .topbar-title {
            font-family: 'Nunito', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a2e;
        }
        .topbar-user {
            display: flex;
            align-items: center;
            gap: .75rem;
        }
        .topbar-user .user-name {
            font-size: .82rem;
            font-weight: 600;
            color: #444;
        }
        .topbar-user .user-role {
            font-size: .72rem;
            color: #aaa;
        }
        .topbar-user i {
            font-size: 1.3rem;
            color: var(--brand);
        }
        .btn-logout {
            font-size: .78rem;
            font-weight: 600;
            color: #666;
            background: #f4f6f9;
            border: 1px solid #e5e7eb;
            padding: .35rem .9rem;
            border-radius: 7px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .4rem;
            cursor: pointer;
            transition: background .15s, color .15s;
        }
        .btn-logout:hover { background: #fee2e2; color: #dc2626; border-color: #fca5a5; }

        /* ── Content area ── */
        #content-wrapper {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-h);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        #main-content {
            flex: 1;
            padding: 1.75rem;
        }

        /* ── Card tweaks ── */
        .card { border: none; border-radius: 10px; }
        .card.shadow { box-shadow: 0 2px 12px rgba(0,0,0,.07) !important; }
        .card-header {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            border-radius: 10px 10px 0 0 !important;
        }
        .border-start-primary { border-left: 4px solid #4e73df !important; }
        .border-start-success { border-left: 4px solid #1cc88a !important; }
        .border-start-warning { border-left: 4px solid #f6c23e !important; }

        /* ── Pagination — normalise Bootstrap 5 against tablesorter theme conflicts ── */
        .pagination {
            display: flex !important;
            flex-wrap: wrap;
            align-items: center;
            gap: .25rem;
            margin: 0;
            padding: 0;
        }
        .pagination .page-item { display: inline-flex; }
        .pagination .page-link {
            font-size: .82rem !important;
            line-height: 1.5 !important;
            padding: .35rem .7rem !important;
            border-radius: 6px !important;
            min-width: 2rem;
            text-align: center;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
        }
        .pagination .page-link svg { width: 14px !important; height: 14px !important; }

        /* ── Responsive ── */
        @media (max-width: 767px) {
            #sidebar { width: 0; overflow: hidden; }
            #sidebar.open { width: var(--sidebar-width); }
            #topbar { left: 0; }
            #content-wrapper { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- Sidebar --}}
    <nav id="sidebar">
        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('h2whoa_admin/assets/img/elements/h2whoa_logo.png') }}" alt="H2WHOA" width="36" height="36">
            <span>H2WHOA</span>
        </a>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.stocks') }}" class="{{ request()->routeIs('admin.stocks*') ? 'active' : '' }}">
                    <i class="fas fa-boxes"></i> Stocks
                </a>
            </li>
            <li>
                <a href="{{ route('admin.sales.index') }}" class="{{ request()->routeIs('admin.sales*') ? 'active' : '' }}">
                    <i class="fas fa-cash-register"></i> Sales
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i> Orders
                </a>
            </li>
            <li>
                <a href="{{ route('admin.history') }}" class="{{ request()->routeIs('admin.history') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> History
                </a>
            </li>
            <li>
                <a href="{{ route('admin.activity-log') }}" class="{{ request()->routeIs('admin.activity-log*') ? 'active' : '' }}">
                    <i class="fas fa-list-alt"></i> Activity Log
                </a>
            </li>
            <li>
                <a href="{{ route('admin.upload-image') }}" class="{{ request()->routeIs('admin.upload-image') ? 'active' : '' }}">
                    <i class="fas fa-upload"></i> Upload Image
                </a>
            </li>
        </ul>
    </nav>

    {{-- Topbar --}}
    <header id="topbar">
        <div class="topbar-title">@yield('title', 'Dashboard')</div>
        <div class="topbar-user">
            <i class="far fa-user"></i>
            <div>
                <div class="user-name">Admin</div>
                <div class="user-role">Administrator</div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </header>

    {{-- Content --}}
    <div id="content-wrapper">
        <div id="main-content">
            @yield('content')
        </div>
    </div>

    <script nonce="{{ csp_nonce() }}" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script nonce="{{ csp_nonce() }}" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_admin/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_admin/assets/js/bs-init.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
