@extends('layouts.app')
@section('title', $course->title)
@section('content')
<a href="{{ route('student.enrollments.index') }}" class="btn btn-link mb-2"><i class="bi bi-arrow-left"></i> Volver a mis cursos</a>
<div class="row">
    <div class="col-md-8">
        <h2>{{ $course->title }}</h2>
        <p class="text-muted">Profesor: <strong>{{ $course->teacher->name }}</strong> · {{ $course->duration_hours }} horas · {{ ucfirst($course->level) }}</p>
        <p>{{ $course->description }}</p>

        <h4 class="mt-4">Contenido</h4>
        @forelse($course->modules as $module)
            <div class="card mb-3">
                <div class="card-header bg-primary text-white"><strong>Módulo {{ $loop->iteration }}:</strong> {{ $module->title }}</div>
                <div class="list-group list-group-flush">
                    @foreach($module->lessons as $lesson)
                        <div class="list-group-item">
                            <h6><i class="bi bi-play-circle"></i> {{ $lesson->title }}</h6>
                            @if($lesson->video_url)
                                <a href="{{ $lesson->video_url }}" target="_blank" class="btn btn-sm btn-outline-primary">Ver video</a>
                            @endif
                            @if($lesson->content)
                                <div class="mt-2 small">{!! nl2br(e($lesson->content)) !!}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-muted">El profesor aún no ha publicado el contenido del curso.</p>
        @endforelse
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <img src="{{ $course->image ? asset('storage/'.$course->image) : 'https://placehold.co/600x300/0d6efd/fff?text='.urlencode($course->title) }}" class="card-img-top">
            <div class="card-body">
                <h6>Categoría</h6>
                <p>{{ $course->category->name ?? 'Sin categoría' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
