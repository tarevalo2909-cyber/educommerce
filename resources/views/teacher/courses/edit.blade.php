@extends('layouts.app')
@section('title', 'Editar curso')
@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h2 class="mb-0"><i class="bi bi-pencil-square"></i> Editar curso: {{ $course->title }}</h2>
    <a href="{{ route('teacher.courses.content.index', $course) }}" class="btn btn-primary"><i class="bi bi-journal-richtext"></i> Gestionar contenido</a>
</div>
<div class="card shadow-sm p-4 mt-3">
    <form action="{{ route('teacher.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('teacher.courses._form')
    </form>
</div>
@endsection
