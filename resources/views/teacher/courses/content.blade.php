@extends('layouts.app')
@section('title', 'Contenido · ' . $course->title)

@push('styles')
<style>
    .module-card { border-left: 4px solid var(--brand); }
    .module-card .card-header {
        background: var(--brand-soft);
        border-bottom: 1px solid #f1ead9;
        display:flex; align-items:center; justify-content:space-between; gap:1rem;
    }
    .module-card .card-header .module-title { font-weight:700; color: var(--ink); margin:0; }
    .lesson-item {
        background:#fff; border:1px solid #f1ead9; border-radius:.7rem;
        padding:.9rem 1rem; margin-bottom:.65rem;
    }
    .lesson-item .lesson-head { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; }
    .lesson-item h6 { margin:0; color: var(--ink); }
    .lesson-actions .btn { padding:.2rem .55rem; }
    .add-block {
        background:#fff; border:2px dashed #e4dccc; border-radius:.8rem;
        padding:1rem; transition: border-color .15s, background .15s;
    }
    .add-block:hover { border-color: var(--brand); background: var(--brand-soft); }
    .collapse-toggle { cursor:pointer; user-select:none; }
    .collapse-toggle i.bi-chevron-down { transition: transform .2s; }
    .collapse-toggle.collapsed i.bi-chevron-down { transform: rotate(-90deg); }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <a href="{{ route('teacher.courses.index') }}" class="btn btn-link p-0 mb-1"><i class="bi bi-arrow-left"></i> Mis cursos</a>
        <h2 class="mb-0"><i class="bi bi-journal-richtext"></i> Contenido del curso</h2>
        <p class="text-muted mb-0">{{ $course->title }}</p>
    </div>
    <a href="{{ route('teacher.courses.edit', $course) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i> Editar curso</a>
</div>

@if($course->modules->isEmpty())
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Este curso aún no tiene módulos. Agrega el primero para empezar a organizar el contenido.
    </div>
@endif

@foreach($course->modules as $module)
    <div class="card module-card mb-3 shadow-sm">
        <div class="card-header">
            <div class="collapse-toggle d-flex align-items-center gap-2 flex-grow-1" data-bs-toggle="collapse" data-bs-target="#mod-{{ $module->id }}" aria-expanded="true">
                <i class="bi bi-chevron-down"></i>
                <h5 class="module-title">Módulo {{ $loop->iteration }}: {{ $module->title }}</h5>
                <span class="badge bg-light text-dark ms-2">{{ $module->lessons->count() }} {{ Str::plural('lección', $module->lessons->count()) }}</span>
            </div>
            <div class="d-flex gap-1">
                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editModule{{ $module->id }}"><i class="bi bi-pencil"></i></button>
                <form action="{{ route('teacher.courses.content.modules.destroy', [$course, $module]) }}" method="POST" onsubmit="return confirm('¿Eliminar el módulo y todas sus lecciones?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
        <div class="collapse show" id="mod-{{ $module->id }}">
            <div class="card-body">
                @forelse($module->lessons as $lesson)
                    <div class="lesson-item">
                        <div class="lesson-head">
                            <div class="flex-grow-1">
                                <h6><i class="bi bi-play-circle text-primary"></i> {{ $loop->iteration }}. {{ $lesson->title }}</h6>
                                @if($lesson->video_url)
                                    <small class="text-muted"><i class="bi bi-link-45deg"></i> <a href="{{ $lesson->video_url }}" target="_blank">{{ $lesson->video_url }}</a></small>
                                @endif
                                @if($lesson->content)
                                    <div class="mt-2 small text-secondary">{{ Str::limit($lesson->content, 200) }}</div>
                                @endif
                            </div>
                            <div class="lesson-actions d-flex gap-1">
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editLesson{{ $lesson->id }}"><i class="bi bi-pencil"></i></button>
                                <form action="{{ route('teacher.courses.content.lessons.destroy', [$course, $module, $lesson]) }}" method="POST" onsubmit="return confirm('¿Eliminar lección?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal editar lección --}}
                    <div class="modal fade" id="editLesson{{ $lesson->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <form class="modal-content" action="{{ route('teacher.courses.content.lessons.update', [$course, $module, $lesson]) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar lección</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Título</label>
                                        <input type="text" name="title" class="form-control" value="{{ $lesson->title }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">URL del video <small class="text-muted">(opcional)</small></label>
                                        <input type="url" name="video_url" class="form-control" value="{{ $lesson->video_url }}" placeholder="https://youtube.com/...">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Contenido / descripción</label>
                                        <textarea name="content" rows="5" class="form-control">{{ $lesson->content }}</textarea>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label fw-semibold">Posición</label>
                                        <input type="number" name="position" min="0" class="form-control" value="{{ $lesson->position }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
                                    <button class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small mb-3"><i class="bi bi-info-circle"></i> Aún no hay lecciones en este módulo.</p>
                @endforelse

                {{-- Form agregar lección --}}
                <div class="add-block mt-3">
                    <form action="{{ route('teacher.courses.content.lessons.store', [$course, $module]) }}" method="POST">
                        @csrf
                        <h6 class="mb-3"><i class="bi bi-plus-circle"></i> Agregar lección</h6>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" name="title" class="form-control" placeholder="Título de la lección" required>
                            </div>
                            <div class="col-md-6">
                                <input type="url" name="video_url" class="form-control" placeholder="URL del video (opcional)">
                            </div>
                            <div class="col-12">
                                <textarea name="content" rows="2" class="form-control" placeholder="Descripción / contenido (opcional)"></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Agregar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal editar módulo --}}
    <div class="modal fade" id="editModule{{ $module->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('teacher.courses.content.modules.update', [$course, $module]) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar módulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Título</label>
                        <input type="text" name="title" class="form-control" value="{{ $module->title }}" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Posición</label>
                        <input type="number" name="position" min="0" class="form-control" value="{{ $module->position }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

{{-- Form agregar módulo --}}
<div class="add-block">
    <form action="{{ route('teacher.courses.content.modules.store', $course) }}" method="POST">
        @csrf
        <h6 class="mb-3"><i class="bi bi-plus-square"></i> Agregar módulo</h6>
        <div class="row g-2">
            <div class="col-md-9">
                <input type="text" name="title" class="form-control" placeholder="Ej: Introducción al curso" required>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100"><i class="bi bi-plus-lg"></i> Agregar módulo</button>
            </div>
        </div>
    </form>
</div>
@endsection
