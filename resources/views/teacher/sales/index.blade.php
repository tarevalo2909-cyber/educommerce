@extends('layouts.app')
@section('title', 'Mis ventas')
@section('content')
<h2><i class="bi bi-cash-coin"></i> Mis ventas</h2>
<div class="row g-3 my-3">
    <div class="col-md-6">
        <div class="card shadow-sm stat-card">
            <div class="card-body">
                <small class="text-muted">Ingresos totales</small>
                <h3 class="text-primary mb-0">$ {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm stat-card">
            <div class="card-body">
                <small class="text-muted">Ventas aprobadas</small>
                <h3 class="text-success mb-0">{{ $totalSales }}</h3>
            </div>
        </div>
    </div>
</div>
<div class="card shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>#</th><th>Estudiante</th><th>Curso</th><th>Monto</th><th>Fecha</th></tr></thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->student->name }}</td>
                    <td>{{ $order->course->title }}</td>
                    <td>$ {{ number_format($order->amount, 0, ',', '.') }}</td>
                    <td>{{ optional($order->reviewed_at)->format('d/m/Y H:i') ?? $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Aún no tienes ventas aprobadas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
