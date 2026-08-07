@extends('layouts.adminlte')
@section('title', 'Tambah User')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1>
            <i class="fas fa-edit"></i> Tambah User
        </h1>
        <p>
            <i class="fas fa-chevron-right"></i> Form <i class="fas fa-chevron-right"></i> Tambah User
        </p>
    </div>
    <a href="javascript:history.back()" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Form Container -->
<div class="form-container-clean">
    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf
        <div class="form-body">
            <div class="form-group">
                <label>Nama <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Role <span class="text-danger">*</span></label>
                <select name="role" class="form-control" required>
                    <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Admin</option>
                    <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Pembimbing</option>
                    <option value="3" {{ old('role') == 3 ? 'selected' : '' }}>Peserta</option>
                    <option value="4" {{ old('role') == 4 ? 'selected' : '' }}>Kasubbag Umum & Kepegawaian</option>
                </select>
            </div>
            <div class="form-group">
                <label>Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
