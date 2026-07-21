@extends('layouts.adminlte')
@section('title', 'Edit User')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1>
            <i class="fas fa-edit"></i> Edit User
        </h1>
        <p>
            <i class="fas fa-chevron-right"></i> Form <i class="fas fa-chevron-right"></i> Edit User
        </p>
    </div>
    <a href="javascript:history.back()" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Form Container -->
<div class="form-container-clean">
    <form action="{{ route('admin.user.update', $user) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <label>Nama <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Role <span class="text-danger">*</span></label>
                <select name="role" class="form-control" required>
                    <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>Admin</option>
                    <option value="2" {{ old('role', $user->role) == 2 ? 'selected' : '' }}>Pembimbing</option>
                    <option value="3" {{ old('role', $user->role) == 3 ? 'selected' : '' }}>Peserta</option>
                </select>
            </div>
            <div class="form-group">
                <label>Password <small class="text-muted">(kosongkan jika tidak ingin mengubah)</small></label>
                <input type="password" name="password" class="form-control">
            </div>
        </div>
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
