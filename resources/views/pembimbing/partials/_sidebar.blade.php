{{-- Pembimbing Sidebar Partial --}}
<li class="nav-item"><a href="{{ route('pembimbing.peserta.index') }}" class="nav-link {{ Request::is('pembimbing/peserta*') ? 'active' : '' }}"><i class="nav-icon fas fa-users"></i><p>Peserta Bimbingan</p></a></li>
<li class="nav-item"><a href="{{ route('pembimbing.absensi.index') }}" class="nav-link {{ Request::is('pembimbing/absensi*') ? 'active' : '' }}"><i class="nav-icon fas fa-calendar-check"></i><p>Kelola Absensi</p></a></li>
<li class="nav-item"><a href="{{ route('pembimbing.penilaian.index') }}" class="nav-link {{ Request::is('pembimbing/penilaian*') ? 'active' : '' }}"><i class="nav-icon fas fa-star"></i><p>Penilaian</p></a></li>
