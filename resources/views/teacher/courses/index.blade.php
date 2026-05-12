@extends('layouts.app')
@section('title', 'Mis cursos')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-collection-play"></i> Mis cursos</h2>
    <a href="{{ route('teacher.courses.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nuevo curso</a>
</div>
<div class="row g-3">
    @forelse($courses as $course)
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <img src="{{ $course->image ? asset('storage/'.$course->image) : 'https://placehold.co/600x300/0d6efd/fff?text='.urlencode($course->title) }}" class="card-img-top" style="height:160px; object-fit:cover">
                <div class="card-body">
                    <h5 class="card-title">{{ $course->title }}</h5>
                    <p class="text-muted small mb-1">{{ $course->category->name ?? 'Sin categoría' }} · {{ ucfirst($course->level) }}</p>
                    <strong class="text-primary">$ {{ number_format($course->price, 0, ',', '.') }}</strong>
                    <div class="mt-2 small">
                        <span class="badge bg-info text-dark">{{ $course->enrollments_count }} matriculados</span>
                        <span class="badge bg-secondary">{{ $course->orders_count }} órdenes</span>
                        @if($course->is_published)<span class="badge bg-success">Publicado</span>
                        @else<span class="badge bg-warning text-dark">Borrador</span>@endif
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('teacher.courses.content.index', $course) }}" class="btn btn-sm btn-primary"><i class="bi bi-journal-richtext"></i> Contenido</a>
                    <a href="{{ route('teacher.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Editar</a>
                    <form action="{{ route('teacher.courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar curso?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="alert alert-info">Aún no has creado cursos. <a href="{{ route('teacher.courses.create') }}">Crea el primero</a>.</div></div>
    @endforelse
</div>
<div class="mt-3">{{ $courses->links() }}</div>
@endsection
