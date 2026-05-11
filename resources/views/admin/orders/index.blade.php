@extends('layouts.app')
@section('title', 'Comprobantes de pago')
@section('content')
<h2><i class="bi bi-receipt"></i> Comprobantes de pago</h2>

<form class="row g-2 mb-3" method="GET">
    <div class="col-md-5"><input type="text" class="form-control" name="q" placeholder="Buscar estudiante o curso" value="{{ request('q') }}"></div>
    <div class="col-md-3">
        <select class="form-select" name="status">
            <option value="">Todos los estados</option>
            <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pendientes</option>
            <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Aprobados</option>
            <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rechazados</option>
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-outline-primary w-100">Filtrar</button></div>
</form>

<div class="card shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr><th>#</th><th>Estudiante</th><th>Curso</th><th>Monto</th><th>Estado</th><th>Fecha</th><th>Revisado por</th><th></th></tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->student->name }}<br><small class="text-muted">{{ $order->student->email }}</small></td>
                    <td>{{ $order->course->title }}<br><small class="text-muted">{{ $order->course->teacher->name }}</small></td>
                    <td>$ {{ number_format($order->amount, 0, ',', '.') }}</td>
                    <td>
                        @if($order->isPending())<span class="badge badge-status-pending">Pendiente</span>
                        @elseif($order->isApproved())<span class="badge badge-status-approved">Aprobado</span>
                        @else<span class="badge badge-status-rejected">Rechazado</span>@endif
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->reviewer->name ?? '—' }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Ver</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
