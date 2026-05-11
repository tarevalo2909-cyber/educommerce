@extends('layouts.app')
@section('title', 'Comprobantes pendientes')
@section('content')
<h2><i class="bi bi-hourglass-split"></i> Reporte de comprobantes pendientes</h2>

<div class="row g-3 my-3">
    <div class="col-md-4">
        <div class="card shadow-sm stat-card" style="border-left-color:#ffc107">
            <div class="card-body">
                <small class="text-muted">Pendientes</small>
                <h3 class="text-warning mb-0">{{ $pendingCount }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm stat-card" style="border-left-color:#198754">
            <div class="card-body">
                <small class="text-muted">Aprobados</small>
                <h3 class="text-success mb-0">{{ $approvedCount }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm stat-card" style="border-left-color:#dc3545">
            <div class="card-body">
                <small class="text-muted">Rechazados</small>
                <h3 class="text-danger mb-0">{{ $rejectedCount }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Distribución total de comprobantes</h6></div>
            <div class="card-body"><canvas id="chartStatus"></canvas></div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Comprobantes esperando revisión</h6></div>
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>#</th><th>Estudiante</th><th>Curso</th><th>Monto</th><th>Días en espera</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($pendingOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->student->name }}</td>
                            <td>{{ $order->course->title }}</td>
                            <td>$ {{ number_format($order->amount, 0, ',', '.') }}</td>
                            <td>
                                @php $days = $order->created_at->diffInDays(now()); @endphp
                                <span class="badge {{ $days >= 3 ? 'bg-danger' : ($days >= 1 ? 'bg-warning text-dark' : 'bg-secondary') }}">{{ $days }} día(s)</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Revisar</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4"><i class="bi bi-check2-circle"></i> No hay comprobantes pendientes.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
new Chart(document.getElementById('chartStatus'), {
    type: 'doughnut',
    data: {
        labels: ['Pendientes', 'Aprobados', 'Rechazados'],
        datasets: [{data: [{{ $pendingCount }}, {{ $approvedCount }}, {{ $rejectedCount }}], backgroundColor:['#ffc107','#198754','#dc3545']}]
    },
    options: {responsive: true, plugins: {legend: {position: 'bottom'}}}
});
</script>
@endpush
@endsection
