@extends('layouts.app')
@section('title', 'Comprar curso')
@section('content')
<h2><i class="bi bi-cart"></i> Comprar curso</h2>
<div class="row mt-3">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <img src="{{ $course->image ? asset('storage/'.$course->image) : 'https://placehold.co/600x300/0d6efd/fff?text='.urlencode($course->title) }}" class="card-img-top" style="height:200px; object-fit:cover">
            <div class="card-body">
                <h4>{{ $course->title }}</h4>
                <p class="text-muted">Profesor: {{ $course->teacher->name }}</p>
                <h2 class="text-primary">S/ {{ number_format($course->price, 2) }}</h2>
            </div>
        </div>
        <div class="alert alert-info mt-3">
            <h6 class="mb-2"><i class="bi bi-bank"></i> Datos para transferir</h6>
            <small>
                <strong>BCP:</strong> 191-12345678-0-12<br>
                <strong>Interbank:</strong> 200-3001234567<br>
                <strong>Yape/Plin:</strong> 999 888 777
            </small>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card shadow-sm p-4">
            <h5>Sube tu comprobante</h5>
            <form action="{{ route('student.orders.store', $course->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Banco</label>
                    <select name="bank" class="form-select" required>
                        <option value="">Selecciona...</option>
                        @foreach(['BCP','BBVA','Interbank','Scotiabank','Yape','Plin'] as $b)
                            <option value="{{ $b }}">{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">N° de operación</label>
                    <input type="text" name="operation_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha de pago</label>
                    <input type="date" name="payment_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Comprobante (imagen o PDF, máx. 3 MB)</label>
                    <input type="file" name="proof" class="form-control" accept="image/*,application/pdf" required>
                </div>
                <button class="btn btn-primary"><i class="bi bi-cloud-upload"></i> Enviar comprobante</button>
                <a href="{{ route('catalog.show', $course->slug) }}" class="btn btn-link">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
