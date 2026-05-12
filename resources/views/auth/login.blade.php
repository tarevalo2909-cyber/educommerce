@extends('layouts.app')

@section('title', 'Iniciar sesión - ' . config('app.name'))

@push('styles')
<style>
    .auth-wrap { min-height: calc(100vh - 200px); display:flex; align-items:center; }
    .auth-card {
        display:grid;
        grid-template-columns: 1.05fr 1fr;
        background:#fff;
        border-radius: 1.4rem;
        overflow:hidden;
        box-shadow: 0 30px 70px rgba(43,33,24,.12), 0 8px 22px rgba(43,33,24,.06);
        max-width: 980px;
        margin: 0 auto;
        width:100%;
    }
    .auth-side {
        position:relative;
        background: linear-gradient(140deg, #c8901c 0%, #a5740f 55%, #6e4d0a 100%);
        color:#fff;
        padding: 3rem 2.5rem;
        display:flex;
        flex-direction:column;
        justify-content:space-between;
        overflow:hidden;
    }
    .auth-side::before {
        content:"";
        position:absolute; inset:auto -60px -90px auto;
        width:280px; height:280px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,.18) 0%, rgba(255,255,255,0) 70%);
    }
    .auth-side::after {
        content:"";
        position:absolute; top:-80px; left:-60px;
        width:240px; height:240px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,.12) 0%, rgba(255,255,255,0) 70%);
    }
    .auth-side .brand-mark { font-size: 2rem; font-weight:800; letter-spacing:.3px; }
    .auth-side h2 { font-weight:800; font-size:1.9rem; line-height:1.2; margin: 1.2rem 0 .6rem; }
    .auth-side p { color: rgba(255,255,255,.85); font-size:.98rem; line-height:1.5; }
    .auth-side .feature { display:flex; gap:.7rem; align-items:flex-start; margin:.6rem 0; }
    .auth-side .feature i { font-size:1.1rem; color:#fff3d6; margin-top:.1rem; }
    .auth-body { padding: 3rem 2.8rem; }
    .auth-body h3 { font-weight:800; color: var(--ink); margin-bottom:.25rem; }
    .auth-body .lead-sub { color: var(--muted); margin-bottom:1.6rem; font-size:.95rem; }
    .field-icon { position:relative; }
    .field-icon i {
        position:absolute; left:.95rem; top:50%; transform:translateY(-50%);
        color:#b9ae97; font-size:1rem;
    }
    .field-icon .form-control { padding-left:2.5rem; }
    .auth-divider { text-align:center; color:var(--muted); font-size:.85rem; margin:1.2rem 0; position:relative; }
    .auth-divider::before, .auth-divider::after {
        content:""; position:absolute; top:50%; width:38%; height:1px; background:#eee2c6;
    }
    .auth-divider::before { left:0; }
    .auth-divider::after { right:0; }
    @media (max-width: 860px) {
        .auth-card { grid-template-columns: 1fr; max-width: 460px; }
        .auth-side { padding: 2rem; }
        .auth-body { padding: 2rem; }
    }
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-side">
            <div>
                <div class="brand-mark"><i class="bi bi-mortarboard-fill"></i> Educommerce</div>
                <h2>Bienvenido de nuevo</h2>
                <p>Continúa aprendiendo desde donde lo dejaste. Accede a tus cursos, compras y certificados en un solo lugar.</p>
            </div>
            <div>
                <div class="feature"><i class="bi bi-check-circle-fill"></i><span>Catálogo de cursos verificados</span></div>
                <div class="feature"><i class="bi bi-check-circle-fill"></i><span>Pagos seguros en pesos colombianos</span></div>
                <div class="feature"><i class="bi bi-check-circle-fill"></i><span>Progreso y reportes personalizados</span></div>
            </div>
        </div>

        <div class="auth-body">
            <h3>Iniciar sesión</h3>
            <p class="lead-sub">Ingresa tus credenciales para acceder a tu cuenta.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                    <div class="field-icon">
                        <i class="bi bi-envelope"></i>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                               placeholder="tu@correo.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Contraseña</label>
                    <div class="field-icon">
                        <i class="bi bi-lock"></i>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password"
                               placeholder="••••••••">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Recuérdame</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="small" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                </button>

                <div class="auth-divider">o</div>

                <p class="text-center mb-0 small">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="fw-semibold">Regístrate aquí</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
