@extends('layouts.app')
@section('title', 'Reporte de usuarios y aprobaciones')
@section('content')
<h2><i class="bi bi-people-fill"></i> Reporte de usuarios y aprobaciones</h2>

<div class="row g-3 my-3">
    <div class="col-md-3">
        <div class="card shadow-sm stat-card">
            <div class="card-body">
                <small class="text-muted">Total usuarios</small>
                <h3 class="text-primary mb-0">{{ $totalUsers }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm stat-card" style="border-left-color:#198754">
            <div class="card-body">
                <small class="text-muted">Estudiantes</small>
                <h3 class="text-success mb-0">{{ $totalStudents }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm stat-card" style="border-left-color:#fd7e14">
            <div class="card-body">
                <small class="text-muted">Profesores</small>
                <h3 class="text-warning mb-0">{{ $totalTeachers }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm stat-card" style="border-left-color:#6f42c1">
            <div class="card-body">
                <small class="text-muted">Tasa de aprobación</small>
                <h3 mb-0>{{ $approvalRate }}%</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Aprobados vs rechazados por administrador</h6></div>
            <div class="card-body"><canvas id="chartByAdmin"></canvas></div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Distribución global (revisados)</h6></div>
            <div class="card-body"><canvas id="chartGlobal"></canvas></div>
        </div>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-header bg-white"><h6 class="mb-0">Detalle por administrador</h6></div>
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>Administrador</th><th>Aprobados</th><th>Rechazados</th><th>Total revisado</th><th>% Aprobación</th></tr></thead>
        <tbody>
            @forelse($byAdmin as $row)
                @php $rTotal = $row->approved + $row->rejected; $rRate = $rTotal > 0 ? round($row->approved/$rTotal*100,1) : 0; @endphp
                <tr>
                    <td>{{ $row->reviewer->name ?? '—' }}</td>
                    <td><span class="badge badge-status-approved">{{ $row->approved }}</span></td>
                    <td><span class="badge badge-status-rejected">{{ $row->rejected }}</span></td>
                    <td>{{ $rTotal }}</td>
                    <td>{{ $rRate }}%</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Aún no hay comprobantes revisados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
new Chart(document.getElementById('chartByAdmin'), {
    type: 'bar',
    data: {
        labels: {!! $chartAdminLabels->toJson() !!},
        datasets: [
            {label:'Aprobados', data: {!! $chartAdminApproved->toJson() !!}, backgroundColor:'#198754'},
            {label:'Rechazados', data: {!! $chartAdminRejected->toJson() !!}, backgroundColor:'#dc3545'}
        ]
    },
    options: {responsive: true, scales: {x: {stacked: true}, y: {stacked: true, beginAtZero:true}}}
});

new Chart(document.getElementById('chartGlobal'), {
    type: 'doughnut',
    data: {
        labels: ['Aprobados', 'Rechazados'],
        datasets: [{data: [{{ $approvedGlobal }}, {{ $rejectedGlobal }}], backgroundColor:['#198754','#dc3545']}]
    },
    options: {responsive: true, plugins: {legend: {position: 'bottom'}}}
});
</script>
@endpush
@endsection
