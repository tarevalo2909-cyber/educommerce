@extends('layouts.app')
@section('title', 'Orden #'.$order->id)
@section('content')
<a href="{{ route('admin.orders.index') }}" class="btn btn-link mb-2"><i class="bi bi-arrow-left"></i> Volver</a>
<div class="row">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><h5 class="mb-0">Detalle de la orden #{{ $order->id }}</h5></div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Estudiante</dt><dd class="col-sm-8">{{ $order->student->name }} <small class="text-muted">({{ $order->student->email }})</small></dd>
                    <dt class="col-sm-4">Curso</dt><dd class="col-sm-8">{{ $order->course->title }}</dd>
                    <dt class="col-sm-4">Profesor</dt><dd class="col-sm-8">{{ $order->course->teacher->name }}</dd>
                    <dt class="col-sm-4">Monto</dt><dd class="col-sm-8">$ {{ number_format($order->amount, 0, ',', '.') }}</dd>
                    <dt class="col-sm-4">Estado</dt><dd class="col-sm-8">
                        @if($order->isPending())<span class="badge badge-status-pending">Pendiente</span>
                        @elseif($order->isApproved())<span class="badge badge-status-approved">Aprobado</span>
                        @else<span class="badge badge-status-rejected">Rechazado</span>@endif
                    </dd>
                    <dt class="col-sm-4">Fecha de compra</dt><dd class="col-sm-8">{{ $order->created_at->format('d/m/Y H:i') }}</dd>
                    @if($order->reviewed_at)
                        <dt class="col-sm-4">Revisado por</dt><dd class="col-sm-8">{{ $order->reviewer->name ?? '—' }} el {{ $order->reviewed_at->format('d/m/Y H:i') }}</dd>
                    @endif
                    @if($order->rejection_reason)
                        <dt class="col-sm-4">Motivo de rechazo</dt><dd class="col-sm-8 text-danger">{{ $order->rejection_reason }}</dd>
                    @endif
                </dl>
            </div>
        </div>

        @if($order->paymentProof)
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-white"><h6 class="mb-0">Comprobante de pago</h6></div>
                <div class="card-body">
                    <dl class="row mb-3">
                        <dt class="col-sm-4">Banco</dt><dd class="col-sm-8">{{ $order->paymentProof->bank ?? '—' }}</dd>
                        <dt class="col-sm-4">N° operación</dt><dd class="col-sm-8">{{ $order->paymentProof->operation_number ?? '—' }}</dd>
                        <dt class="col-sm-4">Fecha de pago</dt><dd class="col-sm-8">{{ optional($order->paymentProof->payment_date)->format('d/m/Y') ?? '—' }}</dd>
                    </dl>
                    @php $ext = pathinfo($order->paymentProof->file_path, PATHINFO_EXTENSION); @endphp
                    @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                        <img src="{{ asset('storage/'.$order->paymentProof->file_path) }}" class="img-fluid rounded border">
                    @else
                        <a href="{{ asset('storage/'.$order->paymentProof->file_path) }}" target="_blank" class="btn btn-outline-primary"><i class="bi bi-file-pdf"></i> Abrir comprobante</a>
                    @endif
                </div>
            </div>
        @endif
    </div>
    <div class="col-md-5">
        @if($order->isPending())
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0">Acciones</h6></div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.approve', $order) }}" method="POST" class="mb-3" onsubmit="return confirm('¿Aprobar esta orden y habilitar el curso al estudiante?')">
                        @csrf
                        <button class="btn btn-success w-100"><i class="bi bi-check-circle"></i> Aprobar comprobante</button>
                    </form>
                    <form action="{{ route('admin.orders.reject', $order) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Motivo del rechazo</label>
                            <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                        </div>
                        <button class="btn btn-danger w-100"><i class="bi bi-x-circle"></i> Rechazar comprobante</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
