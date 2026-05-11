@extends('layouts.app')
@section('title', 'Editar categoría')
@section('content')
<h2><i class="bi bi-tag"></i> Editar categoría</h2>
<div class="card shadow-sm p-4 mt-3">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>
        <button class="btn btn-primary"><i class="bi bi-save"></i> Actualizar</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-link">Cancelar</a>
    </form>
</div>
@endsection
