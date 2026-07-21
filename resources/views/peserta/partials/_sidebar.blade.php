{{-- Peserta Sidebar Partial --}}
<li class="nav-item"><a href="{{ route('peserta.status') }}" class="nav-link {{ Request::is('peserta/status*') ? 'active' : '' }}"><i class="nav-icon fas fa-info-circle"></i><p>Status Pengajuan</p></a></li>
<li class="nav-item"><a href="{{ route('peserta.absensi') }}" class="nav-link {{ Request::is('peserta/absensi*') ? 'active' : '' }}"><i class="nav-icon fas fa-calendar-check"></i><p>Riwayat Absensi</p></a></li>
<li class="nav-item"><a href="{{ route('peserta.penilaian') }}" class="nav-link {{ Request::is('peserta/penilaian*') ? 'active' : '' }}"><i class="nav-icon fas fa-award"></i><p>Penilaian</p></a></li>
<li class="nav-item"><a href="{{ route('peserta.sertifikat') }}" class="nav-link {{ Request::is('peserta/sertifikat*') ? 'active' : '' }}"><i class="nav-icon fas fa-certificate"></i><p>Sertifikat</p></a></li>
