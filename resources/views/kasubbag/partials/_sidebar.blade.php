<li class="nav-header text-uppercase font-weight-bold text-muted px-3 mb-2" style="letter-spacing: 0.5px; opacity: 0.6; font-size: 0.75rem;">Kasubbag Umum & Kepegawaian</li>
<li class="nav-item">
    <a href="{{ route('kasubbag.pengajuan.index') }}" class="nav-link {{ Request::is('kasubbag/pengajuan*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-signature"></i><p>Verifikasi Pengajuan</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('kasubbag.peserta.index') }}" class="nav-link {{ Request::is('kasubbag/peserta*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-map-marked-alt"></i><p>Penempatan Peserta</p>
    </a>
</li>
