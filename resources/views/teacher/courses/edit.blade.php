@extends('layouts.app')
@section('title', 'Editar curso')
@section('content')
<h2><i class="bi bi-pencil-square"></i> Editar curso: {{ $course->title }}</h2>
<div class="card shadow-sm p-4 mt-3">
    <form action="{{ route('teacher.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('teacher.courses._form')
    </form>
</div>
@endsection
