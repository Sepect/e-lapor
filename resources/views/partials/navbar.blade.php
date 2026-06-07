<nav class="app-header navbar navbar-expand fixed-top bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            @if(Auth::check() && Auth::user()->role === 'admin')
                <li class="nav-item d-none d-md-block">
                    <a href="/admin"
                        class="nav-link d-flex align-items-center {{ request()->is('admin') ? 'active fw-bold text-primary' : '' }}">
                        <i class="fas fa-tachometer-alt me-2 opacity-75"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item d-none d-md-block">
                    <a href="{{ route('admin.penerimaan.index') }}"
                        class="nav-link d-flex align-items-center {{ request()->routeIs('admin.penerimaan.index') ? 'active fw-bold text-success' : '' }}">
                        <i class="fas fa-truck me-2 opacity-75"></i> Penerimaan
                    </a>
                </li>
                <li class="nav-item dropdown d-none d-md-block">
                    <a href="#"
                        class="nav-link dropdown-toggle d-flex align-items-center {{ request()->is('admin/laporan*') ? 'active fw-bold text-info' : '' }}"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-file-invoice me-2 opacity-75"></i> Laporan
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-3 mt-2" style="min-width: 240px;">
                        <li>
                            <h6 class="dropdown-header text-uppercase fw-bold text-muted pb-2"
                                style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                <i class="fas fa-industry me-1"></i> Limbah B3
                            </h6>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('admin.laporan.penghasil') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('admin.laporan.penghasil') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Penghasil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('admin.laporan.transporter') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('admin.laporan.transporter') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Transporter
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('admin.laporan.lengkap') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('admin.laporan.lengkap') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Keseluruhan/Lengkap
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider my-2 opacity-50">
                        </li>
                        <li>
                            <h6 class="dropdown-header text-uppercase fw-bold text-muted pb-2"
                                style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                <i class="fas fa-wallet me-1"></i> PAD
                            </h6>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('admin.laporan.potensi_pad') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('admin.laporan.potensi_pad') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Potensi PAD
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('admin.laporan.penerimaan_pad') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('admin.laporan.penerimaan_pad') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Penerimaan PAD
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('admin.laporan.piutang_pad') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('admin.laporan.piutang_pad') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Piutang PAD
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item d-none d-md-block">
                    <a href="{{ route('admin.pengguna.index') }}"
                        class="nav-link d-flex align-items-center {{ request()->routeIs('admin.pengguna.index') ? 'active fw-bold text-warning' : '' }}">
                        <i class="fas fa-cog me-2 opacity-75"></i> Setting
                    </a>
                </li>
            @elseif(Auth::check() && Auth::user()->role === 'penghasil')
                <li class="nav-item d-none d-md-block">
                    <a href="{{ route('penghasil.dashboard') }}"
                        class="nav-link d-flex align-items-center {{ request()->routeIs('penghasil.dashboard') ? 'active fw-bold text-success' : '' }}">
                        <i class="fas fa-tachometer-alt me-2 opacity-75"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item dropdown d-none d-md-block">
                    <a href="#"
                        class="nav-link dropdown-toggle d-flex align-items-center {{ request()->routeIs('penghasil.profil') || request()->routeIs('penghasil.kontrak') ? 'active fw-bold text-success' : '' }}"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-building me-2 opacity-75"></i> Profil & Kontrak
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-3 mt-2" style="min-width: 240px;">
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('penghasil.profil') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('penghasil.profil') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Profil Penghasil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('penghasil.kontrak') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('penghasil.kontrak') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Kontrak Kerjasama
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown d-none d-md-block">
                    <a href="#"
                        class="nav-link dropdown-toggle d-flex align-items-center {{ request()->routeIs('penghasil.limbah') || request()->routeIs('penghasil.beritaAcara') ? 'active fw-bold text-success' : '' }}"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-balance-scale me-2 opacity-75"></i> Pengelolaan Limbah
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-3 mt-2" style="min-width: 240px;">
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('penghasil.limbah') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('penghasil.limbah') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Jumlah Limbah Diolah
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('penghasil.beritaAcara') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('penghasil.beritaAcara') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> BA Penerimaan Limbah B3
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown d-none d-md-block">
                    <a href="#"
                        class="nav-link dropdown-toggle d-flex align-items-center {{ request()->routeIs('penghasil.tagihan') || request()->routeIs('penghasil.pembayaran') ? 'active fw-bold text-success' : '' }}"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-wallet me-2 opacity-75"></i> Keuangan
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-3 mt-2" style="min-width: 240px;">
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('penghasil.tagihan') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('penghasil.tagihan') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Tagihan & Laporan
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('penghasil.pembayaran') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('penghasil.pembayaran') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Setor Biaya Pengolahan
                            </a>
                        </li>
                    </ul>
                </li>
            @elseif(Auth::check() && Auth::user()->role === 'transporter')
                <li class="nav-item d-none d-md-block">
                    <a href="{{ route('transporter.dashboard') }}"
                        class="nav-link d-flex align-items-center {{ request()->routeIs('transporter.dashboard') ? 'active fw-bold text-success' : '' }}">
                        <i class="fas fa-tachometer-alt me-2 opacity-75"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item dropdown d-none d-md-block">
                    <a href="#"
                        class="nav-link dropdown-toggle d-flex align-items-center {{ request()->routeIs('transporter.profil') || request()->routeIs('transporter.kontrak') ? 'active fw-bold text-success' : '' }}"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-building me-2 opacity-75"></i> Profil & Kontrak
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-3 mt-2" style="min-width: 240px;">
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('transporter.profil') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('transporter.profil') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Profil Transporter
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('transporter.kontrak') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('transporter.kontrak') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Kontrak Kerjasama
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown d-none d-md-block">
                    <a href="#"
                        class="nav-link dropdown-toggle d-flex align-items-center {{ request()->routeIs('transporter.limbah') || request()->routeIs('transporter.beritaAcara') ? 'active fw-bold text-success' : '' }}"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-balance-scale me-2 opacity-75"></i> Pengangkutan Limbah
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-3 mt-2" style="min-width: 240px;">
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('transporter.limbah') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('transporter.limbah') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Pengangkutan Limbah B3
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('transporter.beritaAcara') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('transporter.beritaAcara') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> BA Penerimaan Limbah B3
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown d-none d-md-block">
                    <a href="#"
                        class="nav-link dropdown-toggle d-flex align-items-center {{ request()->routeIs('transporter.tagihan') || request()->routeIs('transporter.pad') || request()->routeIs('transporter.retribusi') ? 'active fw-bold text-success' : '' }}"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-wallet me-2 opacity-75"></i> Keuangan
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-3 mt-2" style="min-width: 240px;">
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('transporter.tagihan') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('transporter.tagihan') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Surat Tagihan
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('transporter.pad') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('transporter.pad') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Setor PAD
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 px-3 d-flex align-items-center {{ request()->routeIs('transporter.retribusi') ? 'active bg-success text-white' : '' }}"
                                href="{{ route('transporter.retribusi') }}">
                                <i class="fas fa-chevron-right me-2 text-muted small"></i> Setor Retribusi
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nav-item d-none d-md-block">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <i class="fas fa-home me-2 opacity-75"></i> Halaman Utama
                    </a>
                </li>
            @endif
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/img/user2-160x160.jpg') }}" class="user-image rounded-circle shadow"
                        alt="User Image">
                    <span class="d-none d-md-inline">{{Auth::user()->nama_user}}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="{{ asset('assets/img/user2-160x160.jpg') }}" class="rounded-circle shadow"
                            alt="User Image">
                        <p>
                            {{Auth::user()->nama_user}} - {{strtoupper(Auth::user()->role)}}
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="{{ route('akun.index') }}" class="btn btn-default btn-flat">Pengaturan
                            Akun</a>
                        <a href="#" onclick="konfirmasiLogout(event)"
                            class="btn btn-default btn-flat float-end">Logout</a>
                    </li>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </li>
        </ul>
    </div>
</nav>