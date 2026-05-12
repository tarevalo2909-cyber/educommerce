<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Educommerce'))</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #c8901c;
            --brand-dark: #a5740f;
            --brand-light: #f3c969;
            --brand-soft: #fff6e0;
            --ink: #2b2118;
            --muted: #6b6256;
            --bg: #fbf7f0;
            --bs-primary: #c8901c;
            --bs-primary-rgb: 200,144,28;
            --bs-link-color: #a5740f;
            --bs-link-hover-color: #8a5d08;
        }
        * { box-sizing:border-box; }
        html, body { height:100%; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
        }
        a { color: var(--brand-dark); }
        a:hover { color: #8a5d08; }

        /* Bootstrap primary overrides */
        .bg-primary { background-color: var(--brand) !important; }
        .text-primary { color: var(--brand) !important; }
        .border-primary { border-color: var(--brand) !important; }
        .btn-primary {
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
            border:none; color:#fff; font-weight:600; letter-spacing:.2px;
            padding: .55rem 1.1rem; border-radius: .6rem;
            box-shadow: 0 4px 14px rgba(200,144,28,.25);
            transition: transform .15s ease, box-shadow .2s ease, filter .2s ease;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(135deg, var(--brand-dark) 0%, #7e5505 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(200,144,28,.35);
            color:#fff;
        }
        .btn-outline-primary { color: var(--brand-dark); border-color: var(--brand); border-radius:.6rem; }
        .btn-outline-primary:hover { background: var(--brand); color:#fff; border-color: var(--brand); }
        .btn-link { color: var(--brand-dark); text-decoration:none; }
        .btn-link:hover { color: #8a5d08; text-decoration:underline; }
        .btn { border-radius:.55rem; }

        .form-control, .form-select {
            border-radius:.55rem;
            border:1px solid #e4dccc;
            padding:.6rem .85rem;
            background:#fff;
            transition: border-color .15s, box-shadow .15s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 .2rem rgba(200,144,28,.18);
        }
        .form-check-input:checked { background-color: var(--brand); border-color: var(--brand); }
        .form-check-input:focus { box-shadow: 0 0 0 .2rem rgba(200,144,28,.18); border-color: var(--brand); }

        /* Navbar */
        .navbar {
            background: linear-gradient(95deg, #2b2118 0%, #3a2c1d 60%, #4a3722 100%) !important;
            padding: .85rem 0;
        }
        .navbar-brand { font-weight:800; letter-spacing:.3px; color:#fff !important; }
        .navbar-brand i { color: var(--brand-light); }
        .navbar .nav-link { color: rgba(255,255,255,.82) !important; font-weight:500; padding:.5rem .9rem !important; border-radius:.4rem; transition: color .15s, background .15s; }
        .navbar .nav-link:hover { color:#fff !important; background: rgba(255,255,255,.06); }
        .navbar .dropdown-menu { border:none; border-radius:.7rem; box-shadow:0 10px 30px rgba(0,0,0,.12); padding:.4rem; }
        .navbar .dropdown-item { border-radius:.4rem; padding:.5rem .8rem; }
        .navbar .dropdown-item:hover { background: var(--brand-soft); color: var(--brand-dark); }
        .navbar .badge.bg-light { background: var(--brand-light) !important; color: var(--ink) !important; font-weight:600; }

        /* Cards */
        .card {
            border:none;
            border-radius: 1rem;
            box-shadow: 0 4px 24px rgba(43,33,24,.06);
            background:#fff;
        }
        .card-header {
            background:#fff;
            border-bottom:1px solid #f1ead9;
            font-weight:700;
            color: var(--ink);
            padding: 1rem 1.25rem;
            border-top-left-radius:1rem !important;
            border-top-right-radius:1rem !important;
        }
        .card-course img { height:180px; object-fit:cover; }

        /* Badges / status */
        .badge-status-pending { background:#ffc107; color:#000; }
        .badge-status-approved { background:#198754; color:#fff; }
        .badge-status-rejected { background:#dc3545; color:#fff; }
        .badge { border-radius:.45rem; padding:.4em .6em; font-weight:600; }

        /* Stat cards */
        .stat-card { border-left:4px solid var(--brand); border-radius:.8rem; }

        /* Alerts */
        .alert { border:none; border-radius:.7rem; }

        /* Tables */
        .table { --bs-table-hover-bg: var(--brand-soft); }
        thead th { font-weight:600; color: var(--muted); border-bottom:2px solid #efe7d3 !important; }

        /* Pagination */
        .page-link { color: var(--brand-dark); border-radius:.4rem; margin:0 2px; border-color:#ece4d2; }
        .page-item.active .page-link { background: var(--brand); border-color: var(--brand); }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="bi bi-mortarboard-fill"></i> {{ config('app.name', 'Educommerce') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('catalog.index') }}">Catálogo</a></li>
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.orders.index') }}">Comprobantes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.categories.index') }}">Categorías</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Reportes</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.reports.sales') }}">Cursos vendidos</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.reports.pending') }}">Comprobantes pendientes</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.reports.users') }}">Usuarios / aprobaciones</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(auth()->user()->isTeacher())
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.courses.index') }}">Mis cursos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.sales.index') }}">Mis ventas</a></li>
                    @endif
                    @if(auth()->user()->isStudent())
                        <li class="nav-item"><a class="nav-link" href="{{ route('student.orders.index') }}">Mis órdenes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('student.enrollments.index') }}">Mis cursos</a></li>
                    @endif
                @endauth
            </ul>
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            <span class="badge bg-light text-dark ms-1">{{ Auth::user()->roles->pluck('name')->first() }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">@csrf
                                    <button class="dropdown-item" type="submit">Cerrar sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
@stack('scripts')
</body>
</html>
