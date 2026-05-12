@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">DNI</label>
        <input type="text" name="dni" class="form-control" value="{{ old('dni', $user->dni ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Teléfono</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Rol</label>
        <select name="role" class="form-select" required>
            @foreach($roles as $role)
                <option value="{{ $role }}" {{ old('role', isset($user) ? $user->roles->pluck('name')->first() : '')==$role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Contraseña {{ isset($user) ? '(dejar vacío para no cambiar)' : '' }}</label>
        <input type="password" name="password" class="form-control" @if(!isset($user)) required @endif>
    </div>
    <div class="col-md-6">
        <label class="form-label">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="form-control" @if(!isset($user)) required @endif>
    </div>
    <div class="col-12">
        <div class="form-check form-switch">
            <input type="hidden" name="is_active" value="0">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Usuario activo</label>
        </div>
    </div>
</div>
<div class="mt-3">
    <button class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-link">Cancelar</a>
</div>
