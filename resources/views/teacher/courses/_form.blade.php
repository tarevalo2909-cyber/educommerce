@csrf
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Título</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $course->title ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Categoría</label>
        <select name="category_id" class="form-select">
            <option value="">Sin categoría</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $course->category_id ?? '')==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Descripción</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $course->description ?? '') }}</textarea>
    </div>
    <div class="col-md-3">
        <label class="form-label">Precio (COP $)</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $course->price ?? '0.00') }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Nivel</label>
        <select name="level" class="form-select" required>
            @foreach(['basico'=>'Básico','intermedio'=>'Intermedio','avanzado'=>'Avanzado'] as $v=>$lbl)
                <option value="{{ $v }}" {{ old('level', $course->level ?? '')==$v ? 'selected' : '' }}>{{ $lbl }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Duración (horas)</label>
        <input type="number" name="duration_hours" class="form-control" value="{{ old('duration_hours', $course->duration_hours ?? 0) }}" required>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <div class="form-check form-switch">
            <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published" {{ old('is_published', $course->is_published ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_published">Publicado</label>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label">Imagen del curso</label>
        <input type="file" name="image_file" class="form-control" accept="image/*">
        @if(isset($course) && $course->image)<small class="text-muted">Actual: {{ $course->image }}</small>@endif
    </div>
</div>
<div class="mt-3">
    <button class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
    <a href="{{ route('teacher.courses.index') }}" class="btn btn-link">Cancelar</a>
</div>
