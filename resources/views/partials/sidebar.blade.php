<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <div class="text-center py-2 border-bottom border-secondary text-white">
        <small class="d-block text-muted" style="font-size: 0.7rem;">UPT PLB3 DINAS PENGELOLAAN</small>
        <span class="fw-bold" style="font-size: 0.9rem;">LINGKUNGAN HIDUP</span>
    </div>

    <div class="text-center mb-4 p-2 bg-white">
        <img src="{{ asset('assets/img/logo_pemprov.png') }}" alt="Logo Pemprov" class="img-fluid"
            style="max-height: 100px; width: auto;">
    </div>

    <style>
        .sidebar-home-btn {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #ced4da;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }

        .sidebar-home-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            color: #fff;
        }

        .sidebar-home-btn.active {
            background-color: var(--bs-success) !important;
            border-color: var(--bs-success) !important;
            color: #fff !important;
        }
    </style>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <!-- Home Menu -->
                <li class="nav-item mb-3">
                    <span class="nav-link disabled text-muted fw-bold ps-3 py-1"
                        style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        Home
                    </span>
                    <div class="d-flex px-3 gap-2">
                        <a href="/admin"
                            class="sidebar-home-btn btn btn-sm flex-fill py-2 text-center {{ request()->is('admin') ? 'active' : '' }}"
                            style="font-size: 0.8rem;">
                            <i class="fas fa-tachometer-alt d-block mb-1 fs-5"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.penerimaan.index') }}"
                            class="sidebar-home-btn btn btn-sm flex-fill py-2 text-center {{ request()->routeIs('admin.penerimaan.index') ? 'active' : '' }}"
                            style="font-size: 0.8rem;">
                            <i class="fas fa-truck d-block mb-1 fs-5"></i>
                            Penerimaan
                        </a>
                    </div>
                </li>

                <!-- Laporan Menu -->
                <li class="nav-item {{ request()->is('admin/laporan*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Laporan
                            <i class="nav-arrow fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-header text-uppercase text-muted ps-3 py-1" style="font-size: 0.7rem;">Limbah B3
                        </li>
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
                        <li class="nav-header text-uppercase text-muted ps-3 py-1 mt-2" style="font-size: 0.7rem;">PAD
                        </li>
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

                <!-- Master Limbah B3 Menu -->
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.master-limbah.index') }}"
                        class="nav-link {{ request()->routeIs('admin.master-limbah.index') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-flask"></i>
                        <p>
                            Master Limbah B3
                        </p>
                    </a>
                </li>

                <!-- Setting Menu -->
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.pengguna.index') }}"
                        class="nav-link {{ request()->routeIs('admin.pengguna.index') ? 'active bg-success' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Setting
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>