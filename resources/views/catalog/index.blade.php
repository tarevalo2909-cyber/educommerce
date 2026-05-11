@extends('layouts.app')
@section('title', 'Catálogo de cursos')

@section('content')
<div class="bg-primary text-white p-5 rounded mb-4">
    <h1 class="display-5 fw-bold"><i class="bi bi-mortarboard"></i> Aprende lo que quieras, cuando quieras</h1>
    <p class="lead">Cursos creados por profesores expertos. Compra, aprende y crece.</p>
</div>

<form class="row g-2 mb-4" method="GET">
    <div class="col-md-5"><input type="text" class="form-control" name="q" placeholder="Buscar curso..." value="{{ request('q') }}"></div>
    <div class="col-md-3">
        <select class="form-select" name="category">
            <option value="">Todas las categorías</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select class="form-select" name="level">
            <option value="">Cualquier nivel</option>
            <option value="basico" @selected(request('level')=='basico')>Básico</option>
            <option value="intermedio" @selected(request('level')=='intermedio')>Intermedio</option>
            <option value="avanzado" @selected(request('level')=='avanzado')>Avanzado</option>
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
                    <strong class="text-primary">S/ {{ number_format($course->price, 2) }}</strong>
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
