@extends('layouts.adminlte')
@section('title', 'Kelola User')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-user-cog"></i> Kelola Pengguna Sistem</h1>
        <p>Kelola seluruh hak akses akun pengguna sistem, termasuk Admin, Pembimbing, dan Peserta Magang.</p>
    </div>
    <a href="{{ route('admin.user.create') }}" class="action-button">
        <i class="fas fa-plus"></i> Tambah User Baru
    </a>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-list-ul"></i> Daftar Akun Pengguna</h3>
    </div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th>Nama Pengguna</th>
                    <th>Alamat Email</th>
                    <th>Role Akses</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $roleLabels = [1 => 'Admin', 2 => 'Pembimbing', 3 => 'Peserta']; @endphp
                @forelse($users as $user)
                <tr>
                    <td style="font-weight: 600; color: #0f172a;">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 38px; height: 38px; background: #eff6ff; color: #2563eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; border: 1px solid #dbeafe;">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <span style="font-weight: 600; color: #1e293b; display: block;">{{ $user->name }}</span>
                                <small style="color: #64748b; font-size: 0.75rem;">ID Akun: #{{ $user->id }}</small>
                            </div>
                        </div>
                    </td>
                    <td><code style="background: #f1f5f9; padding: 0.25rem 0.5rem; border-radius: 4px; color: #334155; font-size: 0.85rem; font-weight: 600;">{{ $user->email }}</code></td>
                    <td>
                        @if($user->role === 1) 
                            <span class="badge-status rejected" style="background:#fee2e2; color:#b91c1c;"><i class="fas fa-user-shield mr-1"></i> Admin</span>
                        @elseif($user->role === 2) 
                            <span class="badge-status approved" style="background:#dbeafe; color:#1d4ed8;"><i class="fas fa-chalkboard-teacher mr-1"></i> Pembimbing</span>
                        @else 
                            <span class="badge-status pending" style="background:#e0f2fe; color:#0369a1;"><i class="fas fa-user-graduate mr-1"></i> Peserta</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="{{ route('admin.user.edit', $user) }}" class="edit"><i class="fas fa-edit"></i></a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.user.destroy', $user) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" class="delete" onclick="return confirm('Hapus user ini?')"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted" style="text-align: center;">
                        <i class="fas fa-user-slash fa-2x mb-3" style="color: #cbd5e1;"></i>
                        <p style="color: #94a3b8;">Belum ada data user.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($users, 'links') && $users->hasPages())
    <div class="table-footer">
        <span style="color: #64748b; font-size: 0.85rem;">Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} user</span>
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
