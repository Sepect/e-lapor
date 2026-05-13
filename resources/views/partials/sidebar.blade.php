<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand bg-light">
        <a href="/" class="brand-link text-center">
            <img src="{{ asset('assets/img/logo_pemprov.png') }}"
                 alt="Logo"
                 class="brand-image"
                 style="opacity: 1; float: none; max-height: 45px;">
        </a>
    </div>

    <div class="text-center py-2 border-bottom border-secondary text-white">
        <small class="d-block text-muted" style="font-size: 0.7rem;">UPT PLB3 DINAS PENGELOLAAN</small>
        <span class="fw-bold" style="font-size: 0.9rem;">LINGKUNGAN HIDUP</span>
    </div>

    <div class="text-center mb-4 p-2 bg-white">
        <img src="{{ asset('assets/img/logo_pemprov.png') }}"
             alt="Logo Pemprov"
             class="img-fluid"
             style="max-height: 100px; width: auto;">
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="/admin" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>DASHBOARD</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.penerimaan.index') }}"
                       class="nav-link {{ request()->routeIs('admin.penerimaan.index') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>PENERIMAAN LIMBAH B3</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            LAPORAN PENGELOLAAN LIMBAH B3
                            <i class="nav-arrow fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.laporan.penghasil') }}"
                               class="nav-link {{ request()->routeIs('admin.laporan.penghasil') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penghasil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.laporan.transporter') }}"
                               class="nav-link {{ request()->routeIs('admin.laporan.transporter') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transporter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.laporan.lengkap') }}"
                               class="nav-link {{ request()->routeIs('admin.laporan.lengkap') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Keseluruhan/Lengkap</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            LAPORAN PAD
                            <i class="nav-arrow fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.laporan.potensi_pad') }}"
                               class="nav-link {{ request()->routeIs('admin.laporan.potensi_pad') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Potensi PAD</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.laporan.penerimaan_pad') }}"
                               class="nav-link {{ request()->routeIs('admin.laporan.penerimaan_pad') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penerimaan PAD</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.laporan.piutang_pad') }}"
                               class="nav-link {{ request()->routeIs('admin.laporan.piutang_pad') ? 'active bg-success' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Piutang PAD</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.pengguna.index') }}"
                       class="nav-link {{ request()->routeIs('admin.pengguna.index') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            MANAJEMEN PENGGUNA
                        </p>
                    </a>
                </li>

                <li class="nav-item mt-3 border-top pt-2">
                    <a href="{{ route('akun.index') }}"
                       class="nav-link {{ request()->routeIs('akun.index') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>PENGATURAN AKUN</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
