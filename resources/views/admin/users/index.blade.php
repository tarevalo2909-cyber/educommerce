@extends('layouts.app')
@section('title', 'Usuarios')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-people"></i> Usuarios</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nuevo usuario</a>
</div>

<form class="row g-2 mb-3" method="GET">
    <div class="col-md-5"><input type="text" class="form-control" name="q" placeholder="Buscar por nombre o email" value="{{ request('q') }}"></div>
    <div class="col-md-3">
        <select class="form-select" name="role">
            <option value="">Todos los roles</option>
            @foreach($roles as $role)
                <option value="{{ $role }}" @selected(request('role')==$role)>{{ ucfirst($role) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-outline-primary w-100">Filtrar</button></div>
</form>

<div class="card shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>DNI</th><th>Estado</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>@foreach($user->roles as $role)<span class="badge bg-primary">{{ $role->name }}</span>@endforeach</td>
                    <td>{{ $user->dni ?? '—' }}</td>
                    <td>
                        @if($user->is_active)<span class="badge bg-success">Activo</span>
                        @else<span class="badge bg-secondary">Inactivo</span>@endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar usuario?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
