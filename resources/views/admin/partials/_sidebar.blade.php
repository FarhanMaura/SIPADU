<li class="nav-header text-uppercase font-weight-bold text-muted px-3 mb-2" style="letter-spacing: 0.5px; opacity: 0.6; font-size: 0.75rem;">Master Data</li>
<li class="nav-item {{ Request::is('admin/bidang*') || Request::is('admin/pembimbing*') || Request::is('admin/instansi*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('admin/bidang*') || Request::is('admin/pembimbing*') || Request::is('admin/instansi*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-database"></i>
        <p>Data Master <i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.bidang.index') }}" class="nav-link {{ Request::is('admin/bidang*') ? 'active' : '' }}">
                <i class="fas fa-tags nav-icon"></i><p>Bidang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.pembimbing.index') }}" class="nav-link {{ Request::is('admin/pembimbing*') ? 'active' : '' }}">
                <i class="fas fa-user-tie nav-icon"></i><p>Pembimbing</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.instansi.index') }}" class="nav-link {{ Request::is('admin/instansi*') ? 'active' : '' }}">
                <i class="fas fa-building nav-icon"></i><p>Instansi</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-header text-uppercase font-weight-bold text-muted px-3 mt-3 mb-2" style="letter-spacing: 0.5px; opacity: 0.6; font-size: 0.75rem;">Manajemen Magang</li>
<li class="nav-item">
    <a href="{{ route('admin.pengajuan.index') }}" class="nav-link {{ Request::is('admin/pengajuan*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-signature"></i><p>Pengajuan Magang</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.peserta.index') }}" class="nav-link {{ Request::is('admin/peserta*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-graduate"></i><p>Data Peserta</p>
    </a>
</li>

<li class="nav-header text-uppercase font-weight-bold text-muted px-3 mt-3 mb-2" style="letter-spacing: 0.5px; opacity: 0.6; font-size: 0.75rem;">Keamanan & Sistem</li>
<li class="nav-item">
    <a href="{{ route('admin.user.index') }}" class="nav-link {{ Request::is('admin/user*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-cog"></i><p>Kelola User</p>
    </a>
</li>
