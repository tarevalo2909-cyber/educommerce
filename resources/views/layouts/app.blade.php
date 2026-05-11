<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Educommerce'))</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#f5f7fb; }
        .navbar-brand { font-weight:700; }
        .card-course img { height:180px; object-fit:cover; }
        .badge-status-pending { background:#ffc107; color:#000; }
        .badge-status-approved { background:#198754; color:#fff; }
        .badge-status-rejected { background:#dc3545; color:#fff; }
        .stat-card { border-left:4px solid #0d6efd; }
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
