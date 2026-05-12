@extends('layouts.app')

@section('title', 'Crear cuenta - ' . config('app.name'))

@push('styles')
<style>
    .auth-wrap { min-height: calc(100vh - 200px); display:flex; align-items:center; }
    .auth-card {
        display:grid;
        grid-template-columns: 1fr 1.05fr;
        background:#fff;
        border-radius: 1.4rem;
        overflow:hidden;
        box-shadow: 0 30px 70px rgba(43,33,24,.12), 0 8px 22px rgba(43,33,24,.06);
        max-width: 1020px;
        margin: 0 auto;
        width:100%;
    }
    .auth-body { padding: 2.6rem 2.8rem; order:1; }
    .auth-side {
        position:relative;
        background: linear-gradient(140deg, #c8901c 0%, #a5740f 55%, #6e4d0a 100%);
        color:#fff;
        padding: 3rem 2.5rem;
        display:flex; flex-direction:column; justify-content:space-between;
        overflow:hidden; order:2;
    }
    .auth-side::before {
        content:""; position:absolute; inset:auto auto -90px -60px;
        width:280px; height:280px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,.18) 0%, rgba(255,255,255,0) 70%);
    }
    .auth-side::after {
        content:""; position:absolute; top:-80px; right:-60px;
        width:240px; height:240px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,.12) 0%, rgba(255,255,255,0) 70%);
    }
    .auth-side .brand-mark { font-size: 2rem; font-weight:800; }
    .auth-side h2 { font-weight:800; font-size:1.9rem; line-height:1.2; margin: 1.2rem 0 .6rem; }
    .auth-side p { color: rgba(255,255,255,.88); line-height:1.5; }
    .auth-side .feature { display:flex; gap:.7rem; align-items:flex-start; margin:.6rem 0; }
    .auth-side .feature i { font-size:1.1rem; color:#fff3d6; margin-top:.1rem; }

    .auth-body h3 { font-weight:800; color: var(--ink); margin-bottom:.25rem; }
    .auth-body .lead-sub { color: var(--muted); margin-bottom:1.4rem; font-size:.95rem; }
    .field-icon { position:relative; }
    .field-icon i {
        position:absolute; left:.95rem; top:50%; transform:translateY(-50%);
        color:#b9ae97; font-size:1rem;
    }
    .field-icon .form-control { padding-left:2.5rem; }
    @media (max-width: 860px) {
        .auth-card { grid-template-columns: 1fr; max-width: 460px; }
        .auth-side { padding: 2rem; order:1; }
        .auth-body { padding: 2rem; order:2; }
    }
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-body">
            <h3>Crear cuenta</h3>
            <p class="lead-sub">Únete a Educommerce y empieza a aprender hoy mismo.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nombre completo</label>
                    <div class="field-icon">
                        <i class="bi bi-person"></i>
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                               placeholder="Tu nombre">
                        @error('name')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                    <div class="field-icon">
                        <i class="bi bi-envelope"></i>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email"
                               placeholder="tu@correo.com">
                        @error('email')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold">Contraseña</label>
                        <div class="field-icon">
                            <i class="bi bi-lock"></i>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="new-password"
                                   placeholder="••••••••">
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="password-confirm" class="form-label fw-semibold">Confirmar</label>
                        <div class="field-icon">
                            <i class="bi bi-shield-lock"></i>
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required autocomplete="new-password"
                                   placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 mt-4">
                    <i class="bi bi-person-plus me-1"></i> Crear mi cuenta
                </button>

                <p class="text-center small mt-3 mb-0">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="fw-semibold">Inicia sesión</a>
                </p>
            </form>
        </div>

        <div class="auth-side">
            <div>
                <div class="brand-mark"><i class="bi bi-mortarboard-fill"></i> Educommerce</div>
                <h2>Aprende sin límites</h2>
                <p>Crea tu cuenta gratis y descubre cursos diseñados por expertos para impulsar tu carrera profesional.</p>
            </div>
            <div>
                <div class="feature"><i class="bi bi-stars"></i><span>Cursos en múltiples categorías</span></div>
                <div class="feature"><i class="bi bi-credit-card-2-front"></i><span>Pago seguro con comprobante</span></div>
                <div class="feature"><i class="bi bi-graph-up-arrow"></i><span>Avanza a tu propio ritmo</span></div>
                <div class="feature"><i class="bi bi-people"></i><span>Comunidad de estudiantes activa</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
