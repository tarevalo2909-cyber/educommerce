@extends('layouts.app')
@section('title', 'Mis órdenes')
@section('content')
<h2><i class="bi bi-receipt"></i> Mis órdenes</h2>
<div class="card shadow-sm mt-3">
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>#</th><th>Curso</th><th>Monto</th><th>Estado</th><th>Fecha</th><th>Observación</th></tr></thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->course->title }}</td>
                    <td>S/ {{ number_format($order->amount, 2) }}</td>
                    <td>
                        @if($order->isPending())<span class="badge badge-status-pending">Pendiente</span>
                        @elseif($order->isApproved())<span class="badge badge-status-approved">Aprobado</span>
                        @else<span class="badge badge-status-rejected">Rechazado</span>@endif
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($order->isApproved())
                            <a href="{{ route('student.enrollments.show', $order->course->slug) }}" class="btn btn-sm btn-success">Ir al curso</a>
                        @elseif($order->isRejected())
                            <small class="text-danger">{{ $order->rejection_reason }}</small>
                        @else
                            <small class="text-muted">En revisión</small>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">Aún no has realizado compras. <a href="{{ route('catalog.index') }}">Ver catálogo</a>.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
