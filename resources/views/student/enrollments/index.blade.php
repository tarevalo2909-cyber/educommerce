@extends('layouts.app')
@section('title', 'Mis cursos')
@section('content')
<h2><i class="bi bi-collection"></i> Mis cursos</h2>
<div class="row g-3 mt-2">
    @forelse($enrollments as $enrollment)
        @php $course = $enrollment->course; @endphp
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <img src="{{ $course->image ? asset('storage/'.$course->image) : 'https://placehold.co/600x300/0d6efd/fff?text='.urlencode($course->title) }}" class="card-img-top" style="height:160px; object-fit:cover">
                <div class="card-body">
                    <h5>{{ $course->title }}</h5>
                    <small class="text-muted">Profesor: {{ $course->teacher->name }}</small>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('student.enrollments.show', $course->slug) }}" class="btn btn-primary w-100"><i class="bi bi-play"></i> Continuar</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="alert alert-info">Aún no estás inscrito en ningún curso. <a href="{{ route('catalog.index') }}">Explora el catálogo</a>.</div></div>
    @endforelse
</div>
<div class="mt-3">{{ $enrollments->links() }}</div>
@endsection
