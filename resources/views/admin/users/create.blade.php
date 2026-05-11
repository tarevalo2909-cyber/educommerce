@extends('layouts.app')
@section('title', 'Nuevo usuario')
@section('content')
<h2><i class="bi bi-person-plus"></i> Nuevo usuario</h2>
<div class="card shadow-sm p-4 mt-3">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @include('admin.users._form')
    </form>
</div>
@endsection
