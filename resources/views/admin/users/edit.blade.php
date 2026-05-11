@extends('layouts.app')
@section('title', 'Editar usuario')
@section('content')
<h2><i class="bi bi-person-gear"></i> Editar usuario</h2>
<div class="card shadow-sm p-4 mt-3">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @method('PUT')
        @include('admin.users._form')
    </form>
</div>
@endsection
