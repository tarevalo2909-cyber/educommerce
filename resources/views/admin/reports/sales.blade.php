@extends('layouts.app')
@section('title', 'Reporte de cursos vendidos')
@section('content')
<h2><i class="bi bi-bar-chart-line"></i> Reporte de cursos vendidos</h2>

<form class="row g-2 my-3" method="GET">
    <div class="col-md-3">
        <label class="form-label small">Desde</label>
        <input type="date" name="from" class="form-control" value="{{ $from->format('Y-m-d') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label small">Hasta</label>
        <input type="date" name="to" class="form-control" value="{{ $to->format('Y-m-d') }}">
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-primary">Aplicar filtros</button>
        <a href="{{ route('admin.reports.sales') }}" class="btn btn-link">Limpiar</a>
    </div>
</form>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm stat-card">
            <div class="card-body">
                <small class="text-muted">Ingresos en el rango</small>
                <h3 class="text-primary mb-0">S/ {{ number_format($totalRevenue, 2) }}</h3>
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

<div class="row g-3">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Top 10 cursos más vendidos</h6></div>
            <div class="card-body"><canvas id="chartTop"></canvas></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Ingresos por mes</h6></div>
            <div class="card-body"><canvas id="chartMonthly"></canvas></div>
        </div>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-header bg-white"><h6 class="mb-0">Detalle por curso</h6></div>
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>#</th><th>Curso</th><th>Profesor</th><th>Ventas</th><th>Ingresos</th></tr></thead>
        <tbody>
            @forelse($topCourses as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->course->title ?? 'Curso eliminado' }}</td>
                    <td>{{ $row->course->teacher->name ?? '—' }}</td>
                    <td>{{ $row->sales_count }}</td>
                    <td>S/ {{ number_format($row->revenue, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Sin datos en el rango seleccionado.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
const topLabels = {!! $chartTopLabels->toJson() !!};
const topData = {!! $chartTopData->toJson() !!};
new Chart(document.getElementById('chartTop'), {
    type: 'bar',
    data: {
        labels: topLabels,
        datasets: [{label: 'Unidades vendidas', data: topData, backgroundColor: '#0d6efd'}]
    },
    options: {indexAxis: 'y', responsive: true, plugins: {legend: {display:false}}}
});

const monthlyLabels = {!! $chartMonthlyLabels->toJson() !!};
const monthlyRevenue = {!! $chartMonthlyRevenue->toJson() !!};
const monthlySales = {!! $chartMonthlySales->toJson() !!};
new Chart(document.getElementById('chartMonthly'), {
    type: 'line',
    data: {
        labels: monthlyLabels,
        datasets: [
            {label: 'Ingresos (S/)', data: monthlyRevenue, borderColor:'#198754', backgroundColor:'rgba(25,135,84,.2)', tension:.3, fill:true, yAxisID:'y'},
            {label: 'Ventas', data: monthlySales, borderColor:'#dc3545', tension:.3, yAxisID:'y1'}
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {position:'left', title:{display:true, text:'S/'}},
            y1: {position:'right', grid:{drawOnChartArea:false}, title:{display:true, text:'Ventas'}}
        }
    }
});
</script>
@endpush
@endsection
