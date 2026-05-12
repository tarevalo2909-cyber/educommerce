@extends('layouts.app')
@section('title', 'Catálogo de cursos')

@section('content')
@push('styles')
<style>
    .catalog-hero {
        position:relative;
        background: linear-gradient(135deg, #c8901c 0%, #a5740f 55%, #6e4d0a 100%);
        color:#fff;
        padding: 3rem 2.5rem;
        border-radius: 1.2rem;
        margin-bottom: 1.75rem;
        overflow:hidden;
        box-shadow: 0 12px 36px rgba(165,116,15,.25);
    }
    .catalog-hero::before {
        content:""; position:absolute; top:-80px; right:-60px;
        width:260px; height:260px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,.18) 0%, rgba(255,255,255,0) 70%);
    }
    .catalog-hero::after {
        content:""; position:absolute; bottom:-100px; left:-40px;
        width:240px; height:240px; border-radius:50%;
        background: radial-gradient(circle, rgba(255,255,255,.12) 0%, rgba(255,255,255,0) 70%);
    }
    .catalog-hero h1 { font-weight:800; letter-spacing:.2px; position:relative; }
    .catalog-hero p { color: rgba(255,255,255,.9); position:relative; margin-bottom:0; }
    .catalog-hero i { color:#fff3d6; }
</style>
@endpush

<div class="catalog-hero">
    <h1 class="display-5 fw-bold"><i class="bi bi-mortarboard"></i> Aprende lo que quieras, cuando quieras</h1>
    <p class="lead">Cursos creados por profesores expertos. Compra, aprende y crece.</p>
</div>

<form class="row g-2 mb-4" method="GET">
    <div class="col-md-5"><input type="text" class="form-control" name="q" placeholder="Buscar curso..." value="{{ request('q') }}"></div>
    <div class="col-md-3">
        <select class="form-select" name="category">
            <option value="">Todas las categorías</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select class="form-select" name="level">
            <option value="">Cualquier nivel</option>
            <option value="basico" {{ request('level')=='basico' ? 'selected' : '' }}>Básico</option>
            <option value="intermedio" {{ request('level')=='intermedio' ? 'selected' : '' }}>Intermedio</option>
            <option value="avanzado" {{ request('level')=='avanzado' ? 'selected' : '' }}>Avanzado</option>
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-primary w-100"><i class="bi bi-search"></i> Buscar</button></div>
</form>

<div class="row g-3">
    @forelse($courses as $course)
        <div class="col-md-4">
            <div class="card card-course h-100 shadow-sm">
                <img src="{{ $course->image ? asset('storage/'.$course->image) : 'https://placehold.co/600x400/0d6efd/fff?text='.urlencode($course->title) }}" class="card-img-top" alt="">
                <div class="card-body">
                    <span class="badge bg-secondary">{{ $course->category->name ?? 'Sin categoría' }}</span>
                    <span class="badge bg-info text-dark">{{ ucfirst($course->level) }}</span>
                    <h5 class="card-title mt-2">{{ $course->title }}</h5>
                    <p class="text-muted small mb-1">Por {{ $course->teacher->name }}</p>
                    <p class="card-text small">{{ Str::limit($course->description, 100) }}</p>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                    <strong class="text-primary">$ {{ number_format($course->price, 0, ',', '.') }}</strong>
                    <a href="{{ route('catalog.show', $course->slug) }}" class="btn btn-sm btn-outline-primary">Ver detalle</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="alert alert-info">No hay cursos disponibles con esos filtros.</div></div>
    @endforelse
</div>

<div class="mt-4">{{ $courses->links() }}</div>
@endsection
