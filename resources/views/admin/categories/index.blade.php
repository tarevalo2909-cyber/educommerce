@extends('layouts.app')
@section('title', 'Categorías')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-tags"></i> Categorías</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nueva</a>
</div>
<div class="card shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>ID</th><th>Nombre</th><th>Slug</th><th># Cursos</th><th>Acciones</th></tr></thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td><code>{{ $category->slug }}</code></td>
                    <td>{{ $category->courses_count }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $categories->links() }}</div>
@endsection
