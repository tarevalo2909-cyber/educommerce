@extends('layouts.app')
@section('title', $course->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <img src="{{ $course->image ? asset('storage/'.$course->image) : 'https://placehold.co/800x400/0d6efd/fff?text='.urlencode($course->title) }}" class="img-fluid rounded mb-3">
        <h1>{{ $course->title }}</h1>
        <p class="text-muted">
            <span class="badge bg-secondary">{{ $course->category->name ?? 'Sin categoría' }}</span>
            <span class="badge bg-info text-dark">{{ ucfirst($course->level) }}</span>
            <i class="bi bi-clock"></i> {{ $course->duration_hours }} horas
            · Profesor: <strong>{{ $course->teacher->name }}</strong>
        </p>
        <h4 class="mt-4">Descripción</h4>
        <p>{{ $course->description }}</p>

        <h4 class="mt-4">Contenido del curso</h4>
        @forelse($course->modules as $module)
            <div class="card mb-2">
                <div class="card-header"><strong>Módulo {{ $loop->iteration }}:</strong> {{ $module->title }}</div>
                <ul class="list-group list-group-flush">
                    @foreach($module->lessons as $lesson)
                        <li class="list-group-item"><i class="bi bi-play-circle"></i> {{ $lesson->title }}</li>
                    @endforeach
                </ul>
            </div>
        @empty
            <p class="text-muted">El profesor aún no ha publicado los módulos.</p>
        @endforelse
    </div>
    <div class="col-md-4">
        <div class="card sticky-top shadow-sm" style="top:20px;">
            <div class="card-body text-center">
                <h2 class="text-primary">S/ {{ number_format($course->price, 2) }}</h2>
                @auth
                    @if(auth()->user()->isStudent())
                        @php $enrolled = auth()->user()->enrollments()->where('course_id', $course->id)->exists(); @endphp
                        @if($enrolled)
                            <a href="{{ route('student.enrollments.show', $course->slug) }}" class="btn btn-success w-100"><i class="bi bi-check-circle"></i> Ya inscrito - Ir al curso</a>
                        @else
                            <a href="{{ route('student.orders.create', $course->slug) }}" class="btn btn-primary w-100"><i class="bi bi-cart"></i> Comprar curso</a>
                        @endif
                    @else
                        <p class="text-muted">Solo estudiantes pueden comprar cursos.</p>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary w-100">Inicia sesión para comprar</a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
