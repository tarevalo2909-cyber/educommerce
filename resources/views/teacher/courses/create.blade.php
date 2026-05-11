@extends('layouts.app')
@section('title', 'Nuevo curso')
@section('content')
<h2><i class="bi bi-journal-plus"></i> Nuevo curso</h2>
<div class="card shadow-sm p-4 mt-3">
    <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data">
        @include('teacher.courses._form')
    </form>
</div>
@endsection
